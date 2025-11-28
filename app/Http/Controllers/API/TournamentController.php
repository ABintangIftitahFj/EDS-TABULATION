<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::with(['teams', 'rounds', 'adjudicators', 'rooms'])->paginate(20);
        return response()->json($tournaments);
    }

    public function show($id)
    {
        $tournament = Tournament::with(['teams', 'rounds', 'adjudicators', 'rooms'])->findOrFail($id);
        return response()->json($tournament);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:tournaments,slug',
            'format' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'location' => 'nullable|string',
            'status' => 'in:upcoming,ongoing,completed,draft',
            'is_public' => 'boolean',
            'settings' => 'nullable|array',
        ]);
        $tournament = Tournament::create($data);
        return response()->json($tournament, 201);
    }

    public function update(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|string',
            'slug' => 'sometimes|string|unique:tournaments,slug,' . $id,
            'format' => 'sometimes|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'location' => 'nullable|string',
            'status' => 'in:upcoming,ongoing,completed,draft',
            'is_public' => 'boolean',
            'settings' => 'nullable|array',
        ]);
        $tournament->update($data);
        return response()->json($tournament);
    }

    public function destroy($id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->delete();
        return response()->json(['message' => 'Tournament deleted']);
    }
}
