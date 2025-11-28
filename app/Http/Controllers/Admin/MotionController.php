<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motion;
use App\Models\Round;
use Illuminate\Http\Request;

class MotionController extends Controller
{
    public function index()
    {
        $motions = Motion::with(['round.tournament'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.motions.index', compact('motions'));
    }

    public function create()
    {
        $rounds = Round::with('tournament')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.motions.create', compact('rounds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'round_id' => 'required|exists:rounds,id',
            'title' => 'required|string|max:500',
            'detail' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'info_slide' => 'nullable|string',
            'is_released' => 'nullable|boolean',
        ]);

        if (!empty($validated['is_released'])) {
            $validated['released_at'] = now();
        }

        Motion::create($validated);

        return redirect()->route('admin.motions.index')
            ->with('success', 'Motion created successfully.');
    }

    public function edit(Motion $motion)
    {
        $rounds = Round::with('tournament')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.motions.edit', compact('motion', 'rounds'));
    }

    public function update(Request $request, Motion $motion)
    {
        $validated = $request->validate([
            'round_id' => 'required|exists:rounds,id',
            'title' => 'required|string|max:500',
            'detail' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'info_slide' => 'nullable|string',
            'is_released' => 'nullable|boolean',
        ]);

        if (!empty($validated['is_released']) && !$motion->is_released) {
            $validated['released_at'] = now();
        } elseif (empty($validated['is_released'])) {
            $validated['released_at'] = null;
        }

        $motion->update($validated);

        return redirect()->route('admin.motions.index')
            ->with('success', 'Motion updated successfully.');
    }

    public function destroy(Motion $motion)
    {
        $motion->delete();
        
        return redirect()->route('admin.motions.index')
            ->with('success', 'Motion deleted successfully.');
    }
}
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
