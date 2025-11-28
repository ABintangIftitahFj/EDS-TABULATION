<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Speaker;
use App\Models\Adjudicator;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    // Import Teams & Speakers from CSV
    public function importTeams(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
            'tournament_id' => 'required|exists:tournaments,id',
        ]);
        $file = $request->file('csv');
        $rows = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('strtolower', array_shift($rows));
        $created = 0;
        $errors = [];
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $data = array_combine($header, $row);
                // Validate duplicate team
                if (Team::where('tournament_id', $request->tournament_id)->where('name', $data['team_name'])->exists()) {
                    $errors[] = 'Duplicate team: ' . $data['team_name'];
                    continue;
                }
                $team = Team::create([
                    'tournament_id' => $request->tournament_id,
                    'name' => $data['team_name'],
                    'institution' => $data['institution'] ?? null,
                    'status' => 'registered',
                ]);
                // Speakers: speaker1,speaker2,speaker3
                for ($i = 1; $i <= 3; $i++) {
                    $speakerName = $data['speaker'.$i] ?? null;
                    if ($speakerName) {
                        // Validate duplicate speaker
                        if (Speaker::where('team_id', $team->id)->where('name', $speakerName)->exists()) {
                            $errors[] = 'Duplicate speaker: ' . $speakerName . ' in team ' . $team->name;
                            continue;
                        }
                        Speaker::create([
                            'team_id' => $team->id,
                            'name' => $speakerName,
                        ]);
                    }
                }
                $created++;
            }
            DB::commit();
            return response()->json(['created' => $created, 'errors' => $errors]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Import Adjudicators from CSV
    public function importAdjudicators(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
            'tournament_id' => 'required|exists:tournaments,id',
        ]);
        $file = $request->file('csv');
        $rows = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('strtolower', array_shift($rows));
        $created = 0;
        $errors = [];
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $data = array_combine($header, $row);
                if (Adjudicator::where('tournament_id', $request->tournament_id)->where('name', $data['name'])->exists()) {
                    $errors[] = 'Duplicate adjudicator: ' . $data['name'];
                    continue;
                }
                Adjudicator::create([
                    'tournament_id' => $request->tournament_id,
                    'user_id' => $data['user_id'] ?? 1, // fallback, should be mapped
                    'name' => $data['name'],
                    'institution' => $data['institution'] ?? null,
                    'level' => $data['level'] ?? 'panelist',
                    'rating' => $data['rating'] ?? 0,
                ]);
                $created++;
            }
            DB::commit();
            return response()->json(['created' => $created, 'errors' => $errors]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Import Rooms from CSV
    public function importRooms(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
            'tournament_id' => 'required|exists:tournaments,id',
        ]);
        $file = $request->file('csv');
        $rows = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('strtolower', array_shift($rows));
        $created = 0;
        $errors = [];
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $data = array_combine($header, $row);
                if (\App\Models\Room::where('tournament_id', $request->tournament_id)->where('name', $data['name'])->exists()) {
                    $errors[] = 'Duplicate room: ' . $data['name'];
                    continue;
                }
                \App\Models\Room::create([
                    'tournament_id' => $request->tournament_id,
                    'name' => $data['name'],
                    'location' => $data['location'] ?? null,
                    'capacity' => $data['capacity'] ?? null,
                ]);
                $created++;
            }
            DB::commit();
            return response()->json(['created' => $created, 'errors' => $errors]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
