<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Round;
use App\Models\Tournament;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    public function index(Request $request)
    {
        $tournamentFilter = $request->get('tournament_id');
        
        $query = Round::with('tournament')->orderBy('created_at', 'desc');
        
        if ($tournamentFilter) {
            $query->where('tournament_id', $tournamentFilter);
        }
        
        $rounds = $query->paginate(15);
        $tournaments = Tournament::orderBy('name')->get();
        
        return view('admin.rounds.index', compact('rounds', 'tournaments', 'tournamentFilter'));
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

    public function autoStore(Request $request)
    {
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
        ]);

        $tournamentId = $request->input('tournament_id');
        $lastRound = Round::where('tournament_id', $tournamentId)->orderBy('round_number', 'desc')->first();
        $nextNumber = $lastRound ? $lastRound->round_number + 1 : 1;

        Round::create([
            'tournament_id' => $tournamentId,
            'name' => 'Round ' . $nextNumber,
            'round_number' => $nextNumber,
            'type' => 'preliminary',
            'status' => 'draft',
        ]);

        return redirect()->route('admin.tournaments.show', $tournamentId)->with('success', 'Round ' . $nextNumber . ' created automatically.');
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

    public function toggleMotionVisibility(Round $round)
    {
        $round->update([
            'is_motion_published' => !$round->is_motion_published,
            'motion_published_at' => !$round->is_motion_published ? now() : null
        ]);

        return back()->with('success', 
            $round->is_motion_published 
                ? 'Motion is now public' 
                : 'Motion is now hidden'
        );
    }

    public function toggleDrawVisibility(Round $round)
    {
        $round->update([
            'is_draw_published' => !$round->is_draw_published,
            'draw_published_at' => !$round->is_draw_published ? now() : null
        ]);

        return back()->with('success', 
            $round->is_draw_published 
                ? 'Draw is now unlocked and public' 
                : 'Draw is now locked and hidden'
        );
    }
}
