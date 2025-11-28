<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DebateMatch;
use App\Models\Round;
use App\Models\Team;
use App\Models\Room;
use App\Models\Adjudicator;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        $matches = DebateMatch::with(['round.tournament', 'room', 'govTeam', 'oppTeam', 'adjudicator', 'winner'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        $rounds = Round::with('tournament')->orderBy('created_at', 'desc')->get();
        $teams = Team::orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();
        $adjudicators = Adjudicator::orderBy('name')->get();
        
        return view('admin.matches.create', compact('rounds', 'teams', 'rooms', 'adjudicators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'round_id' => 'required|exists:rounds,id',
            'room_id' => 'nullable|exists:rooms,id',
            'gov_team_id' => 'required|exists:teams,id',
            'opp_team_id' => 'required|exists:teams,id',
            'adjudicator_id' => 'nullable|exists:adjudicators,id',
            'winner_id' => 'nullable|exists:teams,id',
            'status' => 'nullable|in:pending,in_progress,completed',
            'is_completed' => 'nullable|boolean',
        ]);

        DebateMatch::create($validated);

        return redirect()->route('admin.matches.index')->with('success', 'Match created successfully.');
    }

    public function edit(DebateMatch $match)
    {
        $rounds = Round::with('tournament')->orderBy('created_at', 'desc')->get();
        $teams = Team::orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();
        $adjudicators = Adjudicator::orderBy('name')->get();
        
        return view('admin.matches.edit', compact('match', 'rounds', 'teams', 'rooms', 'adjudicators'));
    }

    public function update(Request $request, DebateMatch $match)
    {
        $validated = $request->validate([
            'round_id' => 'required|exists:rounds,id',
            'room_id' => 'nullable|exists:rooms,id',
            'gov_team_id' => 'required|exists:teams,id',
            'opp_team_id' => 'required|exists:teams,id',
            'adjudicator_id' => 'nullable|exists:adjudicators,id',
            'winner_id' => 'nullable|exists:teams,id',
            'status' => 'nullable|in:pending,in_progress,completed',
            'is_completed' => 'nullable|boolean',
        ]);

        $match->update($validated);

        return redirect()->route('admin.matches.index')->with('success', 'Match updated successfully.');
    }

    public function destroy(DebateMatch $match)
    {
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Match deleted successfully.');
    }
}
