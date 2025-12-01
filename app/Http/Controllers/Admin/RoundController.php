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

        $round = Round::create($validated);

        $message = '✨ Round "' . $round->name . '" berhasil dibuat secara manual!';

        // Check if AJAX request
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'round' => [
                    'id' => $round->id,
                    'name' => $round->name,
                    'round_number' => $round->round_number,
                ]
            ]);
        }

        return redirect()->route('admin.rounds.index')->with('success', $message);
    }

    public function autoStore(Request $request)
    {
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
        ]);

        $tournamentId = $request->input('tournament_id');
        $lastRound = Round::where('tournament_id', $tournamentId)->orderBy('round_number', 'desc')->first();
        $nextNumber = $lastRound ? $lastRound->round_number + 1 : 1;

        $round = Round::create([
            'tournament_id' => $tournamentId,
            'name' => 'Round ' . $nextNumber,
            'round_number' => $nextNumber,
            'type' => 'preliminary',
            'status' => 'draft',
        ]);

        // Check if AJAX request
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '🎉 Round ' . $nextNumber . ' berhasil dibuat!',
                'round' => [
                    'id' => $round->id,
                    'name' => $round->name,
                    'round_number' => $round->round_number,
                ]
            ]);
        }

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

    public function toggleMotionVisibility(Round $round, Request $request)
    {
        $round->update([
            'is_motion_published' => !$round->is_motion_published,
            'motion_published_at' => !$round->is_motion_published ? now() : null
        ]);

        $message = $round->is_motion_published
            ? '👁️ Motion berhasil dipublish! Peserta sudah bisa melihat motion.'
            : '🔒 Motion berhasil disembunyikan! Motion sekarang private.';

        // Check if AJAX request
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_published' => $round->is_motion_published,
                'round_name' => $round->name
            ]);
        }

        return back()->with('success', $message);
    }

    public function toggleDrawVisibility(Round $round, Request $request)
    {
        $round->update([
            'is_draw_published' => !$round->is_draw_published,
            'draw_published_at' => !$round->is_draw_published ? now() : null
        ]);

        $message = $round->is_draw_published
            ? '🔓 Draw berhasil dipublish! Peserta sudah bisa melihat draw.'
            : '🔐 Draw berhasil dikunci! Draw sekarang private.';

        // Check if AJAX request
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_published' => $round->is_draw_published,
                'round_name' => $round->name
            ]);
        }

        return back()->with('success', $message);
    }

    public function toggleResults(Round $round)
    {
        $round->results_published = !$round->results_published;
        $round->save();

        $status = $round->results_published ? 'Published' : 'Hidden';
        return back()->with('success', "Round results are now $status.");
    }
}
