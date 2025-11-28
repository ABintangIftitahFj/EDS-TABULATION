<?php

namespace App\Services;

use App\Models\Tournament;
use App\Models\Round;

class TournamentManagementService
{
    public function createTournament(array $data)
    {
        return Tournament::create($data);
    }

    public function setupDefaultConfiguration(Tournament $tournament)
    {
        // Example: set default settings or create default rounds/rooms
        $tournament->settings = [
            'preliminary_rounds' => 5,
            'break_teams' => 8,
        ];
        $tournament->save();
    }

    public function generateRounds(Tournament $tournament, $preliminaryRounds)
    {
        for ($i = 1; $i <= $preliminaryRounds; $i++) {
            Round::create([
                'tournament_id' => $tournament->id,
                'name' => 'Round ' . $i,
                'status' => 'draft',
            ]);
        }
    }
}
