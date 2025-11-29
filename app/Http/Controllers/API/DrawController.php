<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Round;
use App\Models\DebateMatch;
use App\Models\Team;
use App\Models\Room;
use App\Models\Adjudicator;
use App\Services\MatchmakingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DrawController extends Controller
{
    protected $matchmakingService;

    public function __construct(MatchmakingService $matchmakingService)
    {
        $this->matchmakingService = $matchmakingService;
    }

    /**
     * Generate Draw - Support both Random and Manual methods
     * 
     * @param Request $request
     * @param int $roundId
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateDraw(Request $request, $roundId)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:random,manual,swiss',
            'pairings' => 'required_if:type,manual|array',
            'pairings.*.gov_team_id' => 'required_if:type,manual|exists:teams,id',
            'pairings.*.opp_team_id' => 'required_if:type,manual|exists:teams,id',
            'pairings.*.room_id' => 'nullable|exists:rooms,id',
            'pairings.*.adjudicator_id' => 'nullable|exists:adjudicators,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $round = Round::findOrFail($roundId);

        // Check if round is locked
        if ($round->is_locked) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot modify draw. Round is locked.'
            ], 403);
        }

        DB::beginTransaction();
        try {
            // Clear existing matches for this round
            DebateMatch::where('round_id', $roundId)->delete();

            $matches = [];

            if ($request->type === 'manual') {
                // Manual Input Method
                $matches = $this->createManualPairings($round, $request->pairings);
            } else {
                // Random or Swiss Method
                $method = $request->type === 'swiss' ? 'swiss' : 'random';
                $matches = $this->matchmakingService->generateRoundDraw($round, $method);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Draw generated successfully',
                'method' => $request->type,
                'matches' => $matches->load(['govTeam', 'oppTeam', 'room', 'adjudicator'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error generating draw: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create manual pairings with conflict validation
     */
    protected function createManualPairings(Round $round, array $pairings)
    {
        $matches = collect();

        foreach ($pairings as $index => $pairing) {
            // Validate: Team cannot debate against itself
            if ($pairing['gov_team_id'] === $pairing['opp_team_id']) {
                throw new \Exception("Team cannot debate against itself (Pairing #{$index})");
            }

            // Validate: Same institution check (optional warning)
            $govTeam = Team::find($pairing['gov_team_id']);
            $oppTeam = Team::find($pairing['opp_team_id']);

            if ($govTeam->institution === $oppTeam->institution) {
                \Log::warning("Same institution pairing detected: {$govTeam->name} vs {$oppTeam->name}");
            }

            // Create the match
            $match = DebateMatch::create([
                'round_id' => $round->id,
                'gov_team_id' => $pairing['gov_team_id'],
                'opp_team_id' => $pairing['opp_team_id'],
                'room_id' => $pairing['room_id'] ?? null,
                'adjudicator_id' => $pairing['adjudicator_id'] ?? null,
                'status' => 'scheduled',
            ]);

            $matches->push($match);
        }

        return $matches;
    }

    /**
     * Lock/Unlock Draw
     */
    public function toggleLock(Request $request, $roundId)
    {
        $validator = Validator::make($request->all(), [
            'is_locked' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $round = Round::findOrFail($roundId);
        $round->update(['is_locked' => $request->is_locked]);

        return response()->json([
            'success' => true,
            'message' => $request->is_locked ? 'Draw locked successfully' : 'Draw unlocked successfully',
            'round' => $round
        ]);
    }

    /**
     * Get Draw for Public View (Only if published AND not locked)
     */
    public function getPublicDraw($roundId)
    {
        $round = Round::with(['matches.govTeam', 'matches.oppTeam', 'matches.room'])
            ->findOrFail($roundId);

        // Only show if published AND not locked
        if (!$round->is_published || $round->is_locked) {
            return response()->json([
                'success' => false,
                'message' => 'Draw is not available yet'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'round' => $round,
            'matches' => $round->matches
        ]);
    }
}
