<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DebateMatch;
use App\Models\Ballot;
use App\Models\Tournament;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BallotController extends Controller
{
    public function index(Request $request)
    {
        // List matches that need balloting
        $tournaments = Tournament::all();
        $selectedTournament = $request->tournament_id ? Tournament::find($request->tournament_id) : $tournaments->first();

        $matches = [];
        if ($selectedTournament) {
            $matches = \App\Models\DebateMatch::whereHas('round', function ($q) use ($selectedTournament) {
                $q->where('tournament_id', $selectedTournament->id);
            })
                ->with(['round', 'adjudicator', 'govTeam', 'oppTeam'])
                ->get();
        }

        return view('admin.ballots.index', compact('tournaments', 'selectedTournament', 'matches'));
    }

    public function create($match_id)
    {
        $match = \App\Models\DebateMatch::with(['round.tournament', 'govTeam.speakers', 'oppTeam.speakers', 'adjudicator'])->findOrFail($match_id);

        return view('admin.ballots.create', compact('match'));
    }

    public function store(Request $request, $match_id)
    {
        $match = DebateMatch::with('round.tournament')->findOrFail($match_id);
        $format = $match->round->tournament->format;

        DB::transaction(function () use ($request, $match, $format) {
            if ($format === 'british') {
                // Handle BP Ranks
                $ranks = $request->input('ranks'); // Array [team_id => rank]

                $updateData = [
                    'status' => 'finished',
                    'is_completed' => true,
                ];

                $winnerId = null;

                foreach ($ranks as $teamId => $rank) {
                    if ($teamId == $match->gov_team_id)
                        $updateData['gov_rank'] = $rank;
                    if ($teamId == $match->opp_team_id)
                        $updateData['opp_rank'] = $rank;
                    if ($teamId == $match->cg_team_id)
                        $updateData['cg_rank'] = $rank;
                    if ($teamId == $match->co_team_id)
                        $updateData['co_rank'] = $rank;

                    if ($rank == 1) {
                        $winnerId = $teamId;
                    }
                }

                $updateData['winner_id'] = $winnerId;
                $match->update($updateData);

            } else {
                // Handle Asian Parliamentary Scores
                $scores = $request->input('scores'); // Array [speaker_id => score]
                $replyScores = $request->input('reply_scores', []); // Array [team_id => score]

                $govTotal = 0;
                $oppTotal = 0;

                foreach ($scores as $speakerId => $score) {
                    Ballot::updateOrCreate(
                        [
                            'match_id' => $match->id,
                            'speaker_id' => $speakerId,
                            'adjudicator_id' => auth()->id() ?? $match->adjudicator_id,
                        ],
                        ['score' => $score]
                    );

                    // Calculate totals
                    $speaker = \App\Models\Speaker::find($speakerId);
                    if ($speaker->team_id == $match->gov_team_id) {
                        $govTotal += $score;
                    } elseif ($speaker->team_id == $match->opp_team_id) {
                        $oppTotal += $score;
                    }
                }

                // Add reply scores to totals
                if (isset($replyScores[$match->gov_team_id])) {
                    $govTotal += $replyScores[$match->gov_team_id];
                }
                if (isset($replyScores[$match->opp_team_id])) {
                    $oppTotal += $replyScores[$match->opp_team_id];
                }

                // Determine winner: Manual override or Score-based
                if ($request->filled('winner_id')) {
                    $winnerId = $request->input('winner_id');
                } else {
                    $winnerId = $govTotal > $oppTotal ? $match->gov_team_id : ($oppTotal > $govTotal ? $match->opp_team_id : null);
                }

                $match->update([
                    'status' => 'completed',
                    'is_completed' => true,
                    'winner_id' => $winnerId,
                    'gov_reply_score' => $replyScores[$match->gov_team_id] ?? null,
                    'opp_reply_score' => $replyScores[$match->opp_team_id] ?? null,
                ]);
            }
        });

        // If request came from iframe (modal), we might want to close it or redirect parent
        // For now, standard redirect
        return redirect()->route('admin.matches.index')->with('success', 'Ballot submitted successfully.');
    }
}
