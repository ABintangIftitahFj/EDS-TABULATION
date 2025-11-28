<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Adjudicator;
use Illuminate\Http\Request;

class AdjudicatorController extends Controller
{
    public function index()
    {
        $adjudicators = Adjudicator::with(['tournament', 'user', 'ballots'])->paginate(20);
        return response()->json($adjudicators);
    }

    public function show($id)
    {
        $adjudicator = Adjudicator::with(['tournament', 'user', 'ballots'])->findOrFail($id);
        return response()->json($adjudicator);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'institution' => 'nullable|string',
            'is_available' => 'boolean',
            'level' => 'in:trainee,panelist,chair,deputy_chair',
            'rating' => 'numeric|min:0|max:10',
        ]);
        $adjudicator = Adjudicator::create($data);
        return response()->json($adjudicator, 201);
    }

    public function update(Request $request, $id)
    {
        $adjudicator = Adjudicator::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|string',
            'institution' => 'nullable|string',
            'is_available' => 'boolean',
            'level' => 'in:trainee,panelist,chair,deputy_chair',
            'rating' => 'numeric|min:0|max:10',
        ]);
        $adjudicator->update($data);
        return response()->json($adjudicator);
    }

    public function destroy($id)
    {
        $adjudicator = Adjudicator::findOrFail($id);
        $adjudicator->delete();
        return response()->json(['message' => 'Adjudicator deleted']);
    }
}
