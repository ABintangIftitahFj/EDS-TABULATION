<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    public function index()
    {
        $rounds = Round::with(['tournament', 'matches'])->paginate(20);
        return response()->json($rounds);
    }

    public function show($id)
    {
        $round = Round::with(['tournament', 'matches'])->findOrFail($id);
        return response()->json($round);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string',
            'motion' => 'nullable|string',
            'info_slide' => 'nullable|string',
            'status' => 'in:draft,generated,released,in_progress,completed',
            'is_published' => 'boolean',
            'is_motion_published' => 'boolean',
            'start_time' => 'nullable|date',
        ]);
        $round = Round::create($data);
        return response()->json($round, 201);
    }

    public function update(Request $request, $id)
    {
        $round = Round::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|string',
            'motion' => 'nullable|string',
            'info_slide' => 'nullable|string',
            'status' => 'in:draft,generated,released,in_progress,completed',
            'is_published' => 'boolean',
            'is_motion_published' => 'boolean',
            'start_time' => 'nullable|date',
        ]);
        $round->update($data);
        return response()->json($round);
    }

    public function destroy($id)
    {
        $round = Round::findOrFail($id);
        $round->delete();
        return response()->json(['message' => 'Round deleted']);
    }
}
