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
        $tournament = Tournament::withCount(['teams', 'adjudicators', 'rounds'])->findOrFail($id);
        return view('tournaments.show', compact('tournament'));
    }

    public function standings($id)
    {
        $tournament = Tournament::with([
            'teams' => function ($query) {
                $query->orderBy('total_vp', 'desc')->orderBy('total_speaker_score', 'desc');
            },
            'teams.speakers' // Eager load speakers through teams
        ])->findOrFail($id);

        // Flatten speakers and sort them
        $speakers = $tournament->teams->flatMap->speakers->sortByDesc('total_score');

        return view('tournaments.standings', compact('tournament', 'speakers'));
    }

    public function matches($id)
    {
        $tournament = Tournament::with([
            'rounds.matches' => function ($query) {
                $query->with(['govTeam', 'oppTeam', 'adjudicator', 'room', 'winner']);
            },
            'rounds.motions'
        ])->findOrFail($id);

        return view('tournaments.matches', compact('tournament'));
    }

    public function motions($id)
    {
        $tournament = Tournament::with([
            'rounds' => function ($query) {
                $query->where('is_motion_published', true);
            }
        ])->findOrFail($id);

        return view('tournaments.motions', compact('tournament'));
    }
}
