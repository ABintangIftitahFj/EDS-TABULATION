<?php

namespace Tests\Feature;

use App\Models\Tournament;
use App\Models\Team;
use App\Models\Speaker;
use App\Models\Round;
use App\Models\DebateMatch;
use App\Models\Adjudicator;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TabulationLogicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Ranking: Tim dengan VP lebih tinggi harus di atas.
     * Jika VP sama, Tim dengan Total Speaker Score lebih tinggi harus di atas.
     */
    public function test_standings_calculation_logic()
    {
        // 1. Setup Tournament
        $tournament = Tournament::create([
            'name' => 'Logic Cup',
            'slug' => 'logic-cup',
            'format' => 'asian',
            'status' => 'ongoing'
        ]);

        $round = Round::create(['tournament_id' => $tournament->id, 'name' => 'R1', 'round_number' => 1, 'results_published' => true]);
        $room = Room::create(['tournament_id' => $tournament->id, 'name' => 'R1']);
        $adj = Adjudicator::create(['tournament_id' => $tournament->id, 'name' => 'Juri']);

        // 2. Buat 2 Tim
        // Tim A: Menang (VP 1), Skor Rendah (225)
        $teamA = Team::create(['tournament_id' => $tournament->id, 'name' => 'Team A (Winner)']);
        $spkA = $this->createSpeakers($teamA);

        // Tim B: Kalah (VP 0), Skor Tinggi (230) -> Kasus unik di debat, kalah tapi skor bagus
        $teamB = Team::create(['tournament_id' => $tournament->id, 'name' => 'Team B (Loser)']);
        $spkB = $this->createSpeakers($teamB);

        // 3. Buat Match & Input Nilai
        $match = DebateMatch::create([
            'round_id' => $round->id,
            'room_id' => $room->id,
            'gov_team_id' => $teamA->id,
            'opp_team_id' => $teamB->id,
            'adjudicator_id' => $adj->id,
            'winner_id' => $teamA->id, // Tim A Menang
            'is_completed' => true
        ]);

        // Input Ballot (Simulasi Score)
        // Kita isi skor speaker Tim B lebih tinggi, tapi Tim A yang menang secara VP
        $this->submitBallot($match, $spkA, 75); // Total 225
        $this->submitBallot($match, $spkB, 77); // Total 231

        // 4. Cek Halaman Standings
        $response = $this->get(route('tournaments.standings', $tournament->id));

        // 5. Assert Urutan
        // Tim A harus muncul SEBELUM Tim B karena VP lebih penting daripada Score
        $response->assertSeeInOrder(['Team A (Winner)', 'Team B (Loser)']);
    }

    // --- Helper ---
    private function createSpeakers($team)
    {
        return [
            Speaker::create(['team_id' => $team->id, 'name' => $team->name . ' 1']),
            Speaker::create(['team_id' => $team->id, 'name' => $team->name . ' 2']),
            Speaker::create(['team_id' => $team->id, 'name' => $team->name . ' 3']),
        ];
    }

    private function submitBallot($match, $speakers, $score)
    {
        foreach ($speakers as $spk) {
            \App\Models\Ballot::create([
                'match_id' => $match->id,
                'speaker_id' => $spk->id,
                'adjudicator_id' => $match->adjudicator_id,
                'score' => $score,
                'team_role' => 'gov', // Dummy role
                'position' => 'Debater'
            ]);
        }
    }
}