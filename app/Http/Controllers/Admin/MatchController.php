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
    public function index(Request $request)
    {
        $query = DebateMatch::with(['round.tournament', 'room', 'govTeam', 'oppTeam', 'adjudicator', 'winner'])
            ->orderBy('created_at', 'desc');

        if ($request->has('tournament_id') && $request->tournament_id) {
            $query->whereHas('round', function ($q) use ($request) {
                $q->where('tournament_id', $request->tournament_id);
            });
        }

        if ($request->has('round_id') && $request->round_id) {
            $query->where('round_id', $request->round_id);
        }

        $matches = $query->paginate(15);
        $rounds = Round::with('tournament')->orderBy('created_at', 'desc')->get();
        return view('admin.matches.index', compact('matches', 'rounds'));
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
            'cg_team_id' => 'nullable|exists:teams,id',
            'co_team_id' => 'nullable|exists:teams,id',
            'adjudicator_id' => 'nullable|exists:adjudicators,id',
            'winner_id' => 'nullable|exists:teams,id',
            'status' => 'nullable|in:scheduled,in_progress,completed',
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
            'cg_team_id' => 'nullable|exists:teams,id',
            'co_team_id' => 'nullable|exists:teams,id',
            'adjudicator_id' => 'nullable|exists:adjudicators,id',
            'winner_id' => 'nullable|exists:teams,id',
            'status' => 'nullable|in:scheduled,in_progress,completed',
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

    public function autoGenerate(Request $request)
    {
        $request->validate([
            'round_id' => 'required|exists:rounds,id',
        ]);

        $round = Round::with('tournament')->findOrFail($request->round_id);
        $tournament = $round->tournament;
        $teams = $tournament->teams->shuffle();
        $rooms = $tournament->rooms;
        $adjudicators = $tournament->adjudicators;

        // Determine chunk size based on format
        $chunkSize = $tournament->format === 'british' ? 4 : 2;
        $chunks = $teams->chunk($chunkSize);

        $matchesCreated = 0;
        $roomIndex = 0;
        $adjIndex = 0;

        foreach ($chunks as $chunk) {
            if ($chunk->count() < $chunkSize) {
                // Skip incomplete chunks (bye)
                continue;
            }

            $teams = $chunk->values();

            $matchData = [
                'round_id' => $round->id,
                'room_id' => $rooms[$roomIndex]->id ?? null,
                'adjudicator_id' => $adjudicators[$adjIndex]->id ?? null,
                'status' => 'scheduled',
                'gov_team_id' => $teams[0]->id,
                'opp_team_id' => $teams[1]->id,
            ];

            if ($tournament->format === 'british') {
                $matchData['cg_team_id'] = $teams[2]->id;
                $matchData['co_team_id'] = $teams[3]->id;
            }

            DebateMatch::create($matchData);

            $matchesCreated++;
            $roomIndex++;
            $adjIndex++;
        }

        $message = "🎲 Auto-generate berhasil! {$matchesCreated} matches sudah dibuat untuk {$round->name}";

        // Check if AJAX request
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'matches_created' => $matchesCreated,
                'round_name' => $round->name,
                'tournament_format' => $tournament->format
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
