<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\Speaker;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['tournament', 'speakers'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $tournaments = Tournament::orderBy('name')->get();
        return view('admin.teams.create', compact('tournaments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'speakers' => 'required|array|min:2',
            'speakers.*.name' => 'required|string|max:255',
        ]);

        $team = Team::create([
            'tournament_id' => $validated['tournament_id'],
            'name' => $validated['name'],
            'institution' => $validated['institution'],
        ]);

        foreach ($validated['speakers'] as $speakerData) {
            Speaker::create([
                'team_id' => $team->id,
                'name' => $speakerData['name'],
            ]);
        }

        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
    }

    public function edit(Team $team)
    {
        $tournaments = Tournament::orderBy('name')->get();
        $team->load('speakers');
        return view('admin.teams.edit', compact('team', 'tournaments'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'speakers' => 'required|array|min:2',
            'speakers.*.id' => 'nullable|exists:speakers,id',
            'speakers.*.name' => 'required|string|max:255',
        ]);

        $team->update([
            'tournament_id' => $validated['tournament_id'],
            'name' => $validated['name'],
            'institution' => $validated['institution'],
        ]);

        // Update speakers
        $existingSpeakerIds = [];
        foreach ($validated['speakers'] as $speakerData) {
            if (isset($speakerData['id'])) {
                $speaker = Speaker::find($speakerData['id']);
                $speaker->update(['name' => $speakerData['name']]);
                $existingSpeakerIds[] = $speaker->id;
            } else {
                $speaker = Speaker::create([
                    'team_id' => $team->id,
                    'name' => $speakerData['name'],
                ]);
                $existingSpeakerIds[] = $speaker->id;
            }
        }

        // Delete removed speakers
        $team->speakers()->whereNotIn('id', $existingSpeakerIds)->delete();

        return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully.');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Team deleted successfully.');
    }
}
