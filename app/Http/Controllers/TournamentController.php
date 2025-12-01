<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::orderBy('created_at', 'desc')->get();
        return view('tournaments.index', compact('tournaments'));
    }

    public function show($id)
    {
        $tournament = Tournament::with(['teams', 'adjudicators', 'rounds'])
            ->withCount(['teams', 'adjudicators', 'rounds'])
            ->findOrFail($id);
        return view('tournaments.show', compact('tournament'));
    }

    public function standings($id)
    {
        $tournament = Tournament::with([
            'teams' => function ($query) {
                $query->orderBy('total_vp', 'desc')->orderBy('total_speaker_score', 'desc');
            },
            'teams.speakers.ballots.match.round', // Eager load ballots with match and round
            'rounds' // Load rounds so we can check results_published
        ])->findOrFail($id);

        // Determine if any round has published results (use filter to handle both boolean and integer values)
        $hasPublishedResults = $tournament->rounds->filter(function ($round) {
            return $round->results_published == true;
        })->count() > 0;

        // Get IDs of rounds with published results
        $publishedRoundIds = $tournament->rounds->filter(function ($round) {
            return $round->results_published == true;
        })->pluck('id')->toArray();

        // Flatten speakers and calculate total_score dynamically from ballots
        $speakers = $tournament->teams->flatMap->speakers->map(function ($speaker) use ($publishedRoundIds) {
            // Only count ballots from rounds with published results
            $validBallots = $speaker->ballots->filter(function ($ballot) use ($publishedRoundIds) {
                return $ballot->match && in_array($ballot->match->round_id, $publishedRoundIds);
            });
            
            $speaker->total_score = $validBallots->sum('score');
            $speaker->ballots_count = $validBallots->count();
            $speaker->average_score = $speaker->ballots_count > 0 
                ? round($speaker->total_score / $speaker->ballots_count, 2) 
                : 0;
            
            return $speaker;
        })->sortByDesc('total_score')->values();

        return view('tournaments.standings', compact('tournament', 'speakers', 'hasPublishedResults'));
    }

    public function matches($id)
    {
        $tournament = Tournament::with([
            'rounds' => function ($query) {
                // Only load rounds where draw is published
                $query->where('is_draw_published', true);
            },
            'rounds.matches' => function ($query) {
                $query->with(['govTeam', 'oppTeam', 'adjudicator', 'room', 'winner', 'ballots']);
            },
            'rounds.motions' => function ($query) {
                // Only show motion if motion is published
                $query->where('is_released', true);
            }
        ])->findOrFail($id);

        return view('tournaments.matches', compact('tournament'));
    }

    public function motions($id)
    {
        $tournament = Tournament::with([
            'rounds' => function ($query) {
                $query->where('is_motion_published', true);
            },
            'rounds.motions' => function ($query) {
                // Filter only visible and published motions if columns exist
                if (\Schema::hasColumn('motions', 'is_visible')) {
                    $query->where('is_visible', true);
                }
                if (\Schema::hasColumn('motions', 'status')) {
                    $query->where('status', 'published');
                }
            }
        ])->findOrFail($id);

        return view('tournaments.motions', compact('tournament'));
    }

    public function results($id, Request $request)
    {
        $roundId = $request->get('round_id');

        $tournament = Tournament::with([
            'rounds' => function ($query) use ($roundId) {
                if ($roundId) {
                    $query->where('id', $roundId);
                }
            },
            'rounds.matches' => function ($query) {
                $query->with([
                    'govTeam.speakers',
                    'oppTeam.speakers',
                    'adjudicator',
                    'room',
                    'winner',
                    'ballots.speaker',
                    'ballots.adjudicator'
                ])->where('is_completed', true);
            }
        ])->findOrFail($id);

        // Get all rounds for dropdown (separate query for dropdown options)
        $allRounds = Tournament::findOrFail($id)->rounds;

        return view('tournaments.results', compact('tournament', 'allRounds', 'roundId'));
    }

    public function speakers($id)
    {
        $tournament = Tournament::with(['rounds.matches', 'teams.speakers.ballots.match'])->findOrFail($id);

        // Check if any round has results_published = true (use filter to handle both boolean and integer values)
        $hasPublishedResults = $tournament->rounds->filter(function ($round) {
            return $round->results_published == true;
        })->count() > 0;

        // Identify completed rounds
        $completedRoundIds = $tournament->rounds->filter(function ($round) {
            return $round->matches->count() > 0 && $round->matches->every(function ($match) {
                return $match->is_completed;
            });
        })->pluck('id')->toArray();

        // Flatten and sort all speakers
        $speakers = $tournament->teams->flatMap->speakers->map(function ($speaker) use ($completedRoundIds) {
            // Calculate score only from completed rounds
            $validBallots = $speaker->ballots->filter(function ($ballot) use ($completedRoundIds) {
                return $ballot->match && in_array($ballot->match->round_id, $completedRoundIds);
            });

            $speaker->calculated_total_score = $validBallots->sum('score');
            $speaker->ballots_count = $validBallots->count();

            return $speaker;
        })
            ->sortByDesc('calculated_total_score')
            ->values()
            ->map(function ($speaker, $index) {
                $speaker->rank = $index + 1;
                // Override the database total_score with our calculated one for display
                $speaker->total_score = $speaker->calculated_total_score;
                return $speaker;
            });

        return view('tournaments.speakers', compact('tournament', 'speakers', 'hasPublishedResults'));
    }

    public function participants($id)
    {
        $tournament = Tournament::with(['teams.speakers', 'adjudicators'])->findOrFail($id);
        return view('tournaments.participants', compact('tournament'));
    }

    public function adjudicators($id)
    {
        $tournament = Tournament::with(['adjudicators' => function($query) {
            $query->orderBy('rating', 'desc');
        }])->findOrFail($id);

        return view('tournaments.adjudicators', compact('tournament'));
    }
}
