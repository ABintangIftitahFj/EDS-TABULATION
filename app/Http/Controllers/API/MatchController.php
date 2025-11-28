<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DebateMatch;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    // List all matches
    public function index()
    {
        $matches = DebateMatch::with(['round', 'room', 'govTeam', 'oppTeam', 'adjudicator', 'ballots'])->paginate(20);
        return response()->json($matches);
    }

    // Show a single match
    public function show($id)
    {
        $match = DebateMatch::with(['round', 'room', 'govTeam', 'oppTeam', 'adjudicator', 'ballots'])->findOrFail($id);
        return response()->json($match);
    }

    // Create a new match
    public function store(Request $request)
    {
        $data = $request->validate([
            'round_id' => 'required|exists:rounds,id',
            'room_id' => 'nullable|exists:rooms,id',
            'adjudicator_id' => 'nullable|exists:adjudicators,id',
            'gov_team_id' => 'required|exists:teams,id',
            'opp_team_id' => 'required|exists:teams,id',
            'status' => 'in:scheduled,completed,in_progress',
        ]);
        $match = DebateMatch::create($data);
        return response()->json($match, 201);
    }

    // Update a match
    public function update(Request $request, $id)
    {
        $match = DebateMatch::findOrFail($id);
        $data = $request->validate([
            'room_id' => 'nullable|exists:rooms,id',
            'adjudicator_id' => 'nullable|exists:adjudicators,id',
            'gov_team_id' => 'nullable|exists:teams,id',
            'opp_team_id' => 'nullable|exists:teams,id',
            'winner_id' => 'nullable|exists:teams,id',
            'status' => 'in:scheduled,completed,in_progress',
            'is_completed' => 'boolean',
        ]);
        $match->update($data);
        return response()->json($match);
    }

    // Delete a match
    public function destroy($id)
    {
        $match = DebateMatch::findOrFail($id);
        $match->delete();
        return response()->json(['message' => 'Match deleted']);
    }

    // Ballot input stub (to be implemented)
    public function inputBallot(Request $request, $id)
    {
        // Implement ballot input logic here
        return response()->json(['message' => 'Ballot input endpoint']);
    }
}
