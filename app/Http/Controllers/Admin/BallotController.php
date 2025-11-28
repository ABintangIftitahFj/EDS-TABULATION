<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DebateMatch;
use App\Models\Ballot;
use App\Models\Tournament;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BallotController extends Controller
{
    public function index(Request $request)
    {
        // List matches that need balloting
        $tournaments = Tournament::all();
        $selectedTournament = $request->tournament_id ? Tournament::find($request->tournament_id) : $tournaments->first();

        $matches = [];
        if ($selectedTournament) {
            $matches = \App\Models\DebateMatch::whereHas('round', function ($q) use ($selectedTournament) {
                $q->where('tournament_id', $selectedTournament->id);
            })
                ->with(['round', 'adjudicator', 'govTeam', 'oppTeam'])
                ->get();
        }

        return view('admin.ballots.index', compact('tournaments', 'selectedTournament', 'matches'));
    }

    public function create($match_id)
    {
        $match = \App\Models\DebateMatch::with(['round.tournament', 'govTeam.speakers', 'oppTeam.speakers', 'adjudicator'])->findOrFail($match_id);

        return view('admin.ballots.create', compact('match'));
    }

    public function store(Request $request, $match_id)
    {
        $match = \App\Models\DebateMatch::findOrFail($match_id);

        // Validation logic would go here (complex for debate scores)

        DB::transaction(function () use ($request, $match) {
            // Save ballots for each speaker
            foreach ($request->scores as $speaker_id => $score) {
                Ballot::updateOrCreate(
                    [
                        'match_id' => $match->id,
                        'speaker_id' => $speaker_id,
                        'adjudicator_id' => auth()->id(), // Assuming current user is the adj or entering for them
                    ],
                    ['score' => $score]
                );
            }

            // Update Match Result logic (simplified)
            // In a real app, you'd calculate the winner based on scores
            $match->update(['result_status' => 'confirmed']);
        });

        return redirect()->route('admin.ballots.index')->with('success', 'Ballot submitted successfully.');
    }
}
