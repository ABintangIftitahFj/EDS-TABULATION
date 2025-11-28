<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adjudicator;
use App\Models\Tournament;
use Illuminate\Http\Request;

class AdjudicatorController extends Controller
{
    public function index()
    {
        $adjudicators = Adjudicator::with('tournament')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.adjudicators.index', compact('adjudicators'));
    }

    public function create()
    {
        $tournaments = Tournament::orderBy('name')->get();
        return view('admin.adjudicators.create', compact('tournaments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:10',
        ]);

        Adjudicator::create($validated);

        return redirect()->route('admin.adjudicators.index')->with('success', 'Adjudicator created successfully.');
    }

    public function edit(Adjudicator $adjudicator)
    {
        $tournaments = Tournament::orderBy('name')->get();
        return view('admin.adjudicators.edit', compact('adjudicator', 'tournaments'));
    }

    public function update(Request $request, Adjudicator $adjudicator)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:10',
        ]);

        $adjudicator->update($validated);

        return redirect()->route('admin.adjudicators.index')->with('success', 'Adjudicator updated successfully.');
    }

    public function destroy(Adjudicator $adjudicator)
    {
        $adjudicator->delete();
        return redirect()->route('admin.adjudicators.index')->with('success', 'Adjudicator deleted successfully.');
    }
}
