<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Round;
use Illuminate\Http\Request;

class MotionController extends Controller
{
    public function index()
    {
        $rounds = Round::with('tournament')
            ->whereNotNull('motion')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.motions.index', compact('rounds'));
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
}
