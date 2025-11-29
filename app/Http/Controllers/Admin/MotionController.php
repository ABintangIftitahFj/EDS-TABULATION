<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Round;
use App\Models\Tournament;
use Illuminate\Http\Request;

class MotionController extends Controller
{
    public function index(Request $request)
    {
        $tournamentFilter = $request->get('tournament_id');
        
        $query = Round::with('tournament')
            ->whereNotNull('motion')
            ->orderBy('created_at', 'desc');
            
        if ($tournamentFilter) {
            $query->where('tournament_id', $tournamentFilter);
        }
        
        $rounds = $query->paginate(15);
        $tournaments = Tournament::orderBy('name')->get();

        return view('admin.motions.index', compact('rounds', 'tournaments', 'tournamentFilter'));
    }

    public function create()
    {
        return redirect()->route('admin.rounds.index')
            ->with('info', 'Please create a round first, then add motion to it.');
    }

    public function edit(Round $round)
    {
        return redirect()->route('admin.rounds.edit', $round)
            ->with('info', 'Edit motion in the round form.');
    }

    public function publishMotion(Round $round)
    {
        $round->update([
            'is_motion_published' => true,
            'motion_published_at' => now(),
        ]);

        return back()->with('success', "Motion for {$round->name} has been published.");
    }

    public function unpublishMotion(Round $round)
    {
        $round->update([
            'is_motion_published' => false,
            'motion_published_at' => null,
        ]);

        return back()->with('success', "Motion for {$round->name} has been unpublished.");
    }

    public function publishDraw(Round $round)
    {
        $round->update([
            'is_draw_published' => true,
            'draw_published_at' => now(),
        ]);

        return back()->with('success', "Draw for {$round->name} has been published.");
    }

    public function unpublishDraw(Round $round)
    {
        $round->update([
            'is_draw_published' => false,
            'draw_published_at' => null,
        ]);

        return back()->with('success', "Draw for {$round->name} has been unpublished.");
    }
}
