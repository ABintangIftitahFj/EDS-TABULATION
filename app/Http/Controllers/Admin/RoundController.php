<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Round;
use App\Models\Tournament;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    public function index()
    {
        $rounds = Round::with('tournament')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.rounds.index', compact('rounds'));
    }

    public function create()
    {
        $tournaments = Tournament::orderBy('name')->get();
        return view('admin.rounds.create', compact('tournaments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string|max:255',
            'round_number' => 'required|integer|min:1',
            'motion' => 'nullable|string',
            'info_slide' => 'nullable|string',
        ]);

        Round::create($validated);

        return redirect()->route('admin.rounds.index')->with('success', 'Round created successfully.');
    }

    public function edit(Round $round)
    {
        $tournaments = Tournament::orderBy('name')->get();
        return view('admin.rounds.edit', compact('round', 'tournaments'));
    }

    public function update(Request $request, Round $round)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string|max:255',
            'round_number' => 'required|integer|min:1',
            'motion' => 'nullable|string',
            'info_slide' => 'nullable|string',
        ]);

        $round->update($validated);

        return redirect()->route('admin.rounds.index')->with('success', 'Round updated successfully.');
    }

    public function destroy(Round $round)
    {
        $round->delete();
        return redirect()->route('admin.rounds.index')->with('success', 'Round deleted successfully.');
    }
}
