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
        $tournament->load(['teams', 'rounds.matches', 'adjudicators']);
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
        // Get imported data summary
        $summary = [
            'teams' => $tournament->teams()->count(),
            'speakers' => $tournament->teams()->with('speakers')->get()->sum(function ($team) {
                return $team->speakers->count(); }),
            'adjudicators' => $tournament->adjudicators()->count(),
            'rooms' => \App\Models\Room::where('tournament_id', $tournament->id)->count(),
            'rounds' => $tournament->rounds()->count(),
        ];

        // Get recent import logs
        $recentImports = \App\Models\ImportLog::where('tournament_id', $tournament->id)
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get()
            ->groupBy('entity_type');

        return view('admin.tournaments.import', compact('tournament', 'summary', 'recentImports'));
    }

    public function processImport(Request $request, Tournament $tournament)
    {
        $isAjax = $request->ajax() || $request->wantsJson();
        
        try {
            $request->validate([
                'type' => 'required|in:teams,adjudicators,rooms,rounds',
                'file' => 'required|file|mimes:csv,txt|max:2048'
            ]);

            $file = $request->file('file');
            $type = $request->type;
            $fileName = $file->getClientOriginalName();

            // Read CSV file
            $content = file_get_contents($file->getRealPath());
            $lines = explode(PHP_EOL, $content);
            $data = [];
            foreach ($lines as $line) {
                if (!empty(trim($line))) {
                    $data[] = str_getcsv($line);
                }
            }

            if (empty($data)) {
                if ($isAjax) {
                    return response()->json(['success' => false, 'message' => 'CSV file is empty.']);
                }
                return redirect()->back()->withErrors(['file' => 'CSV file is empty.']);
            }

            $header = array_shift($data); // Remove header row

            $imported = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                $lineNumber = $index + 2; // +2 because header is line 1, data starts at line 2
                $success = false;
                $message = '';

                try {
                    if ($type === 'teams') {
                        $result = $this->importTeamRow($tournament, $row, $lineNumber);
                    } elseif ($type === 'adjudicators') {
                        $result = $this->importAdjudicatorRow($tournament, $row, $lineNumber);
                    } elseif ($type === 'rooms') {
                        $result = $this->importRoomRow($tournament, $row, $lineNumber);
                    } elseif ($type === 'rounds') {
                        $result = $this->importRoundRow($tournament, $row, $lineNumber);
                    }

                    $success = $result['success'];
                    $message = $result['message'];

                    if ($success) {
                        $imported++;
                    } else {
                        $errors[] = "Line {$lineNumber}: " . $message;
                    }

                } catch (\Exception $e) {
                    $success = false;
                    $message = $e->getMessage();
                    $errors[] = "Line {$lineNumber}: " . $message;
                }

                // Log the import attempt
                \App\Models\ImportLog::create([
                    'tournament_id' => $tournament->id,
                    'file_name' => $fileName,
                    'entity_type' => $type,
                    'line_number' => $lineNumber,
                    'raw_row' => $row,
                    'status' => $success ? 'success' : 'error',
                    'message' => $message,
                ]);
            }

            // Get updated counts
            $counts = [
                'teams' => $tournament->teams()->count(),
                'speakers' => \App\Models\Speaker::whereIn('team_id', $tournament->teams()->pluck('id'))->count(),
                'adjudicators' => $tournament->adjudicators()->count(),
                'rooms' => $tournament->rooms()->count(),
                'rounds' => $tournament->rounds()->count(),
            ];

            if (!empty($errors)) {
                $errorMessage = "Import completed: {$imported} success, " . count($errors) . " failed.";
                if ($isAjax) {
                    return response()->json([
                        'success' => true,
                        'message' => $errorMessage,
                        'counts' => $counts,
                        'errors' => $errors
                    ]);
                }
                return redirect()->back()->with('warning', $errorMessage);
            }

            $successMessage = "Successfully imported {$imported} {$type}.";
            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'counts' => $counts
                ]);
            }
            return redirect()->back()->with('success', $successMessage);

        } catch (\Exception $e) {
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => 'Error processing file: ' . $e->getMessage()]);
            }
            return redirect()->back()->withErrors(['file' => 'Error processing file: ' . $e->getMessage()]);
        }
    }

    private function importRoundRow(Tournament $tournament, array $row, int $lineNumber): array
    {
        if (count($row) < 2) {
            return ['success' => false, 'message' => 'Missing required columns (Name, Round Number)'];
        }

        if (empty(trim($row[0]))) {
            return ['success' => false, 'message' => 'Round name cannot be empty'];
        }

        $roundNumber = intval(trim($row[1] ?? 1));
        if ($roundNumber < 1) {
            return ['success' => false, 'message' => 'Round number must be a positive number'];
        }

        try {
            $round = \App\Models\Round::create([
                'tournament_id' => $tournament->id,
                'name' => trim($row[0]),
                'round_number' => $roundNumber,
                'type' => 'preliminary',
                'motion' => isset($row[2]) && !empty(trim($row[2])) ? trim($row[2]) : null,
                'info_slide' => isset($row[3]) && !empty(trim($row[3])) ? trim($row[3]) : null,
                'is_published' => false,
                'is_motion_published' => false,
                'is_draw_published' => false,
                'is_locked' => false,
                'results_published' => false,
                'status' => 'draft',
            ]);
            
            return ['success' => true, 'message' => "Round '{$round->name}' imported successfully"];
        } catch (\Exception $e) {
            \Log::error('Round import error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    private function importTeamRow(Tournament $tournament, array $row, int $lineNumber): array
    {
        if (count($row) < 2) {
            return ['success' => false, 'message' => 'Missing required columns (Team Name, Institution)'];
        }

        if (empty(trim($row[0]))) {
            return ['success' => false, 'message' => 'Team name cannot be empty'];
        }

        $team = \App\Models\Team::create([
            'tournament_id' => $tournament->id,
            'name' => trim($row[0]),
            'institution' => trim($row[1] ?? ''),
        ]);

        // Import speakers if provided (columns 2+)
        $speakersCount = 0;
        for ($i = 2; $i < count($row); $i++) {
            if (!empty(trim($row[$i]))) {
                \App\Models\Speaker::create([
                    'team_id' => $team->id,
                    'name' => trim($row[$i]),
                ]);
                $speakersCount++;
            }
        }

        $message = "Team '{$team->name}' created";
        if ($speakersCount > 0) {
            $message .= " with {$speakersCount} speakers";
        }

        return ['success' => true, 'message' => $message];
    }

    private function importAdjudicatorRow(Tournament $tournament, array $row, int $lineNumber): array
    {
        if (count($row) < 2) {
            return ['success' => false, 'message' => 'Missing required columns (Name, Institution)'];
        }

        if (empty(trim($row[0]))) {
            return ['success' => false, 'message' => 'Adjudicator name cannot be empty'];
        }

        $adjudicator = \App\Models\Adjudicator::create([
            'tournament_id' => $tournament->id,
            'user_id' => null, // We don't link to users during CSV import
            'name' => trim($row[0]),
            'institution' => trim($row[1]),
            'rating' => isset($row[2]) && is_numeric(trim($row[2])) ? (float) trim($row[2]) : 0,
        ]);

        return ['success' => true, 'message' => "Adjudicator '{$adjudicator->name}' from {$adjudicator->institution} created"];
    }

    private function importRoomRow(Tournament $tournament, array $row, int $lineNumber): array
    {
        if (count($row) < 1 || empty(trim($row[0]))) {
            return ['success' => false, 'message' => 'Room name cannot be empty'];
        }

        $room = \App\Models\Room::create([
            'name' => trim($row[0]),
            'tournament_id' => $tournament->id,
        ]);

        return ['success' => true, 'message' => "Room '{$room->name}' created"];
    }

    public function downloadImportErrors(Tournament $tournament, Request $request)
    {
        $entityType = $request->get('type', 'all');

        $query = \App\Models\ImportLog::where('tournament_id', $tournament->id)
            ->where('status', 'error')
            ->orderBy('created_at', 'desc');

        if ($entityType !== 'all') {
            $query->where('entity_type', $entityType);
        }

        $errors = $query->get();

        $csvContent = "Line Number,Entity Type,Raw Data,Error Message,Date\n";

        foreach ($errors as $error) {
            $rawData = is_array($error->raw_row) ? implode('|', $error->raw_row) : $error->raw_row;
            $csvContent .= "{$error->line_number},{$error->entity_type},\"{$rawData}\",\"{$error->message}\",{$error->created_at}\n";
        }

        $fileName = "import-errors-{$tournament->id}-" . now()->format('Y-m-d-H-i-s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"");
    }
}
