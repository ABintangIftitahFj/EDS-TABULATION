<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ballot;
use App\Models\DebateMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BallotController extends Controller
{
    // List ballots for a match
    public function index($matchId)
    {
        $ballots = Ballot::where('match_id', $matchId)->with(['adjudicator', 'speaker'])->get();
        return response()->json($ballots);
    }

    // Show a single ballot
    public function show($id)
    {
        $ballot = Ballot::with(['adjudicator', 'speaker', 'match'])->findOrFail($id);
        return response()->json($ballot);
    }

    // Store (input) ballots for a match
    public function store(Request $request, $matchId)
    {
        $data = $request->validate([
            'ballots' => 'required|array',
            'ballots.*.adjudicator_id' => 'required|exists:adjudicators,id',
            'ballots.*.speaker_id' => 'required|exists:speakers,id',
            'ballots.*.score' => 'required|integer|min:60|max:100',
            'ballots.*.team_role' => 'required|in:gov,opp',
            'ballots.*.position' => 'required|string',
            'ballots.*.is_reply' => 'boolean',
            'ballots.*.feedback' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            foreach ($data['ballots'] as $ballotData) {
                Ballot::updateOrCreate([
                    'match_id' => $matchId,
                    'adjudicator_id' => $ballotData['adjudicator_id'],
                    'speaker_id' => $ballotData['speaker_id'],
                    'position' => $ballotData['position'],
                ], [
                    'score' => $ballotData['score'],
                    'team_role' => $ballotData['team_role'],
                    'is_reply' => $ballotData['is_reply'] ?? false,
                    'feedback' => $ballotData['feedback'] ?? null,
                ]);
            }
            DB::commit();
            return response()->json(['message' => 'Ballots submitted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Stub: Calculate consensus for a match
    public function consensus($matchId)
    {
        // Implement consensus logic here
        return response()->json(['message' => 'Consensus calculation endpoint']);
    }
}
