<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Round;
use App\Models\DebateMatch;
use App\Models\Team;
use App\Models\Adjudicator;
use App\Models\Ballot;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchManagementController extends Controller
{
    // Get rounds by tournament
    public function getRounds($tournamentId)
    {
        $rounds = Round::where('tournament_id', $tournamentId)
            ->orderBy('created_at', 'asc')
            ->get(['id', 'name']);
        
        return response()->json($rounds);
    }

    // Get matches by round
    public function getMatches($roundId)
    {
        $matches = DebateMatch::with(['govTeam', 'oppTeam', 'room', 'adjudicator'])
            ->where('round_id', $roundId)
            ->get();
        
        return response()->json($matches);
    }

    // Get adjudicators by match/draw
    public function getAdjudicatorsByDraw($matchId)
    {
        $match = DebateMatch::with(['adjudicator', 'round.tournament'])->findOrFail($matchId);
        
        return response()->json([
            'adjudicator' => $match->adjudicator,
            'all_adjudicators' => Adjudicator::where('tournament_id', $match->round->tournament->id)->get()
        ]);
    }

    // Get speakers by team
    public function getSpeakersByTeam($teamId)
    {
        $speakers = Speaker::where('team_id', $teamId)->get();
        return response()->json($speakers);
    }

    // Submit match scores
    public function submitScore(Request $request, $matchId)
    {
        $validated = $request->validate([
            'winner' => 'required|in:government,opposition',
            'gov_scores' => 'required|array',
            'gov_scores.*.speaker_id' => 'required|exists:speakers,id',
            'gov_scores.*.score' => 'required|numeric|min:50|max:100',
            'gov_scores.*.feedback' => 'nullable|string',
            'opp_scores' => 'required|array',
            'opp_scores.*.speaker_id' => 'required|exists:speakers,id',
            'opp_scores.*.score' => 'required|numeric|min:50|max:100',
            'opp_scores.*.feedback' => 'nullable|string',
            'adjudicator_id' => 'required|exists:adjudicators,id',
        ]);

        DB::beginTransaction();
        try {
            $match = DebateMatch::findOrFail($matchId);

            // Clear existing ballots for this match
            Ballot::where('match_id', $matchId)->delete();

            // Save GOV team ballots
            foreach ($validated['gov_scores'] as $govScore) {
                Ballot::create([
                    'match_id' => $matchId,
                    'adjudicator_id' => $validated['adjudicator_id'],
                    'speaker_id' => $govScore['speaker_id'],
                    'score' => $govScore['score'],
                    'feedback' => $govScore['feedback'] ?? null,
                    'team_role' => 'gov',
                    'position' => '1',
                    'is_reply' => false,
                    'is_consensus' => true,
                ]);
            }

            // Save OPP team ballots
            foreach ($validated['opp_scores'] as $oppScore) {
                Ballot::create([
                    'match_id' => $matchId,
                    'adjudicator_id' => $validated['adjudicator_id'],
                    'speaker_id' => $oppScore['speaker_id'],
                    'score' => $oppScore['score'],
                    'feedback' => $oppScore['feedback'] ?? null,
                    'team_role' => 'opp',
                    'position' => '1',
                    'is_reply' => false,
                    'is_consensus' => true,
                ]);
            }

            // Update match result
            $winnerId = $validated['winner'] === 'government' ? $match->gov_team_id : $match->opp_team_id;
            $match->update([
                'winner_id' => $winnerId,
                'is_completed' => true,
                'status' => 'completed',
            ]);

            // Update team records
            $winnerTeam = Team::find($winnerId);
            $loserTeam = Team::find($validated['winner'] === 'government' ? $match->opp_team_id : $match->gov_team_id);
            
            if ($winnerTeam) {
                $winnerTeam->increment('wins');
                $winnerTeam->total_vp = $winnerTeam->wins * 3; // 3 VP per win in AP format
                $winnerTeam->save();
            }
            
            if ($loserTeam) {
                $loserTeam->increment('losses');
                $loserTeam->save();
            }

            // Update speaker scores
            $this->updateSpeakerTotals($match->gov_team_id);
            $this->updateSpeakerTotals($match->opp_team_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Match scores submitted successfully',
                'match' => $match->fresh()->load(['govTeam', 'oppTeam', 'winner', 'ballots.speaker'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error submitting scores: ' . $e->getMessage()
            ], 500);
        }
    }

    // Publish draw
    public function publishDraw(Request $request, $roundId)
    {
        $validated = $request->validate([
            'is_published' => 'required|boolean'
        ]);

        $round = Round::findOrFail($roundId);
        $round->update(['is_published' => $validated['is_published']]);

        return response()->json([
            'success' => true,
            'message' => $validated['is_published'] ? 'Draw published successfully' : 'Draw unpublished successfully',
            'round' => $round
        ]);
    }

    // Publish motion
    public function publishMotion(Request $request, $roundId)
    {
        $validated = $request->validate([
            'is_motion_published' => 'required|boolean'
        ]);

        $round = Round::findOrFail($roundId);
        $round->update(['is_motion_published' => $validated['is_motion_published']]);

        return response()->json([
            'success' => true,
            'message' => $validated['is_motion_published'] ? 'Motion published successfully' : 'Motion unpublished successfully',
            'round' => $round
        ]);
    }

    // Get ballot status for results
    public function getBallotStatus($tournamentId, $roundId = null)
    {
        $query = DebateMatch::with(['govTeam', 'oppTeam', 'room', 'winner', 'round'])
            ->whereHas('round', function($q) use ($tournamentId) {
                $q->where('tournament_id', $tournamentId);
            });

        if ($roundId) {
            $query->where('round_id', $roundId);
        }

        $matches = $query->get();

        $ballotStatus = $matches->map(function($match) {
            return [
                'match_id' => $match->id,
                'room' => $match->room->name ?? 'TBA',
                'round' => $match->round->name,
                'gov_team' => $match->govTeam->name ?? 'TBA',
                'opp_team' => $match->oppTeam->name ?? 'TBA',
                'is_completed' => $match->is_completed,
                'winner' => $match->winner ? ($match->winner_id == $match->gov_team_id ? 'Government Win' : 'Opposition Win') : null,
                'ballot_filled' => $match->is_completed ? 'Yes' : 'No'
            ];
        });

        return response()->json($ballotStatus);
    }

    // Verify password for editing ballots
    public function verifyBallotPassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string'
        ]);

        $isValid = $validated['password'] === 'admin123';

        return response()->json([
            'valid' => $isValid,
            'message' => $isValid ? 'Password verified' : 'Invalid password'
        ]);
    }

    private function updateSpeakerTotals($teamId)
    {
        $speakers = Speaker::where('team_id', $teamId)->get();
        foreach ($speakers as $speaker) {
            $totalScore = Ballot::where('speaker_id', $speaker->id)->sum('score');
            $speaker->update(['total_score' => $totalScore]);
        }
    }
}
