<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Round;
use App\Models\DebateMatch;
use App\Models\Team;
use App\Models\Speaker;
use App\Models\Adjudicator;
use App\Models\Ballot;
use Illuminate\Http\Request;

class MatchScoringController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // Main admin scoring interface
    public function index()
    {
        $tournaments = Tournament::withCount(['teams', 'rounds'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.match-scoring.index', compact('tournaments'));
    }

    // Show scoring interface for specific tournament
    public function show(Tournament $tournament)
    {
        $rounds = Round::where('tournament_id', $tournament->id)
            ->withCount('matches')
            ->with(['matches.govTeam', 'matches.oppTeam', 'matches.room', 'matches.winner'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.match-scoring.show', compact('tournament', 'rounds'));
    }

    // Get match details for scoring
    public function getMatchDetails($matchId)
    {
        $match = DebateMatch::with([
            'govTeam.speakers', 
            'oppTeam.speakers', 
            'room', 
            'adjudicator',
            'ballots.speaker',
            'round'
        ])->findOrFail($matchId);

        return response()->json([
            'match' => $match,
            'gov_speakers' => $match->govTeam->speakers ?? [],
            'opp_speakers' => $match->oppTeam->speakers ?? [],
            'existing_ballots' => $match->ballots->groupBy('team_role')
        ]);
    }

    // Tournament management dashboard
    public function dashboard(Tournament $tournament)
    {
        $stats = [
            'total_rounds' => Round::where('tournament_id', $tournament->id)->count(),
            'total_matches' => DebateMatch::whereHas('round', function($q) use ($tournament) {
                $q->where('tournament_id', $tournament->id);
            })->count(),
            'completed_matches' => DebateMatch::whereHas('round', function($q) use ($tournament) {
                $q->where('tournament_id', $tournament->id);
            })->where('is_completed', true)->count(),
            'published_rounds' => Round::where('tournament_id', $tournament->id)->where('is_published', true)->count(),
        ];

        $recentMatches = DebateMatch::with(['govTeam', 'oppTeam', 'room', 'round', 'winner'])
            ->whereHas('round', function($q) use ($tournament) {
                $q->where('tournament_id', $tournament->id);
            })
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.match-scoring.dashboard', compact('tournament', 'stats', 'recentMatches'));
    }
}