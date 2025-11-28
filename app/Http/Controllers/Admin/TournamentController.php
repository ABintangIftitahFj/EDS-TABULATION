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
        try {
            $request->validate([
                'type' => 'required|in:teams,adjudicators,rooms',
                'file' => 'required|file|mimes:csv,txt|max:2048'
            ]);

            $file = $request->file('file');
            $type = $request->type;

            // Read CSV file
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($data); // Remove header row

            if (empty($data)) {
                return redirect()->back()->withErrors(['file' => 'CSV file is empty.']);
            }

            $imported = 0;
            $errors = [];

            if ($type === 'teams') {
                // Expected format: Team Name, Institution, Speaker 1, Speaker 2, ...
                foreach ($data as $index => $row) {
                    $lineNumber = $index + 2; // +2 because header is line 1, data starts at line 2

                    if (count($row) < 2) {
                        $errors[] = "Line {$lineNumber}: Missing required columns (Team Name, Institution)";
                        continue;
                    }

                    if (empty(trim($row[0]))) {
                        $errors[] = "Line {$lineNumber}: Team name cannot be empty";
                        continue;
                    }

                    try {
                        $team = \App\Models\Team::create([
                            'tournament_id' => $tournament->id,
                            'name' => trim($row[0]),
                            'institution' => trim($row[1] ?? ''),
                        ]);

                        // Import speakers if provided (columns 2+)
                        for ($i = 2; $i < count($row); $i++) {
                            if (!empty(trim($row[$i]))) {
                                \App\Models\Speaker::create([
                                    'team_id' => $team->id,
                                    'name' => trim($row[$i]),
                                ]);
                            }
                        }
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Line {$lineNumber}: " . $e->getMessage();
                    }
                }
            } elseif ($type === 'adjudicators') {
                // Expected format: Name, Institution
                foreach ($data as $index => $row) {
                    $lineNumber = $index + 2;

                    if (count($row) < 2) {
                        $errors[] = "Line {$lineNumber}: Missing required columns (Name, Institution)";
                        continue;
                    }

                    if (empty(trim($row[0]))) {
                        $errors[] = "Line {$lineNumber}: Adjudicator name cannot be empty";
                        continue;
                    }

                    try {
                        \App\Models\Adjudicator::create([
                            'tournament_id' => $tournament->id,
                            'name' => trim($row[0]),
                            'institution' => trim($row[1]),
                        ]);
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Line {$lineNumber}: " . $e->getMessage();
                    }
                }
            } elseif ($type === 'rooms') {
                // Expected format: Name
                foreach ($data as $index => $row) {
                    $lineNumber = $index + 2;

                    if (count($row) < 1 || empty(trim($row[0]))) {
                        $errors[] = "Line {$lineNumber}: Room name cannot be empty";
                        continue;
                    }

                    try {
                        \App\Models\Room::create([
                            'name' => trim($row[0]),
                        ]);
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Line {$lineNumber}: " . $e->getMessage();
                    }
                }
            }

            if (!empty($errors)) {
                $errorMessage = "Imported {$imported} {$type} with " . count($errors) . " errors:\n" . implode("\n", array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $errorMessage .= "\n... and " . (count($errors) - 5) . " more errors.";
                }
                return redirect()->route('admin.tournaments.show', $tournament)
                    ->with('warning', $errorMessage);
            }

            return redirect()->route('admin.tournaments.show', $tournament)
                ->with('success', "Successfully imported {$imported} {$type}.");

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'Error processing file: ' . $e->getMessage()]);
        }
    }
}
