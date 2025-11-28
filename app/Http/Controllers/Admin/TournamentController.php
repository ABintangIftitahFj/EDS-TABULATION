<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        return view('admin.tournaments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'format' => 'required|in:asian,british',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        $validated['status'] = 'upcoming';

        Tournament::create($validated);

        return redirect()->route('admin.tournaments.index')->with('success', 'Tournament created successfully.');
    }

    public function show(Tournament $tournament)
    {
        $tournament->load(['teams', 'rounds', 'adjudicators']);
        return view('admin.tournaments.show', compact('tournament'));
    }

    public function edit(Tournament $tournament)
    {
        return view('admin.tournaments.edit', compact('tournament'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'format' => 'required|in:asian,british',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);

        $tournament->update($validated);

        return redirect()->route('admin.tournaments.index')->with('success', 'Tournament updated successfully.');
    }

    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        return redirect()->route('admin.tournaments.index')->with('success', 'Tournament deleted successfully.');
    }

    public function import(Tournament $tournament)
    {
        return view('admin.tournaments.import', compact('tournament'));
    }

    public function processImport(Request $request, Tournament $tournament)
    {
        $request->validate([
            'type' => 'required|in:teams,adjudicators,rooms',
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $type = $request->type;
        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($data);

        $imported = 0;

        if ($type === 'teams') {
            foreach ($data as $row) {
                if (count($row) < 2)
                    continue;

                $team = \App\Models\Team::create([
                    'tournament_id' => $tournament->id,
                    'name' => $row[0],
                    'institution' => $row[1] ?? '',
                ]);

                // Import speakers if provided (columns 2+)
                for ($i = 2; $i < count($row); $i++) {
                    if (!empty($row[$i])) {
                        \App\Models\Speaker::create([
                            'team_id' => $team->id,
                            'name' => $row[$i],
                        ]);
                    }
                }
                $imported++;
            }
        } elseif ($type === 'adjudicators') {
            foreach ($data as $row) {
                if (count($row) < 1)
                    continue;

                \App\Models\Adjudicator::create([
                    'tournament_id' => $tournament->id,
                    'name' => $row[0],
                    'institution' => $row[1] ?? '',
                    'rating' => isset($row[2]) && is_numeric($row[2]) ? $row[2] : null,
                ]);
                $imported++;
            }
        } elseif ($type === 'rooms') {
            foreach ($data as $row) {
                if (count($row) < 1)
                    continue;

                \App\Models\Room::create([
                    'name' => $row[0],
                    'location' => $row[1] ?? '',
                    'capacity' => isset($row[2]) && is_numeric($row[2]) ? $row[2] : null,
                ]);
                $imported++;
            }
        }

        return redirect()->route('admin.tournaments.show', $tournament)
            ->with('success', "Successfully imported {$imported} {$type}.");
    }
}
