<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['tournament', 'speakers'])->paginate(20);
        return response()->json($teams);
    }

    public function show($id)
    {
        $team = Team::with(['tournament', 'speakers'])->findOrFail($id);
        return response()->json($team);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string',
            'institution' => 'nullable|string',
            'status' => 'in:registered,confirmed,disqualified',
        ]);
        $team = Team::create($data);
        return response()->json($team, 201);
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|string',
            'institution' => 'nullable|string',
            'status' => 'in:registered,confirmed,disqualified',
        ]);
        $team->update($data);
        return response()->json($team);
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return response()->json(['message' => 'Team deleted']);
    }
}
