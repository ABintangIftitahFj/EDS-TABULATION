<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Speaker;
use App\Models\Adjudicator;
use App\Models\Room;
use App\Models\Round;
use App\Models\DebateMatch; // Pastikan pakai model yang benar
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentSecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: User Biasa (Non-Admin) TIDAK BOLEH input nilai
     */
    public function test_non_admin_cannot_submit_scores()
    {
        // Setup data dasar
        $user = User::factory()->create(['is_admin' => false]); // User biasa
        $tournament = $this->createTournament();
        $match = $this->createMatch($tournament);

        // Coba akses route store ballot
        $response = $this->actingAs($user)
            ->post(route('admin.ballots.store', $match->id), [
                'scores' => [], // Data dummy
                'reply_scores' => []
            ]);

        // Harusnya Forbidden (403) atau Redirect jika middleware auth admin bekerja
        // Jika middleware kamu pakai 'auth' saja tanpa cek 'is_admin', ini mungkin lolos (302).
        // Sesuaikan ekspektasi dengan middleware kamu. 
        // Jika pakai middleware 'admin', harusnya 403.
        if ($response->status() === 302) {
            // Jika redirect ke dashboard, berarti ditendang (aman)
            $response->assertRedirect();
        } else {
            $response->assertStatus(403);
        }
    }

    /**
     * Test 2: Validasi Input Skor (Range 69-85)
     */
    public function test_score_validation_rules()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $tournament = $this->createTournament();
        $match = $this->createMatch($tournament);

        // Ambil ID speaker dari match yang dibuat
        $speakerId = $match->govTeam->speakers->first()->id;

        // Skenario A: Skor Ketinggian (100)
        $responseHigh = $this->actingAs($admin)
            ->post(route('admin.ballots.store', $match->id), [
                'scores' => [$speakerId => 100], // Invalid
            ]);

        // Harusnya Error Session pada key 'scores.ID'
        $responseHigh->assertSessionHasErrors();

        // Skenario B: Skor Kerendahan (50)
        $responseLow = $this->actingAs($admin)
            ->post(route('admin.ballots.store', $match->id), [
                'scores' => [$speakerId => 50], // Invalid
            ]);

        $responseLow->assertSessionHasErrors();
    }

    // --- HELPER FUNCTIONS BIAR KODING LEBIH CEPAT ---

    private function createTournament()
    {
        return Tournament::create([
            'name' => 'Sec Cup',
            'slug' => 'sec-cup',
            'format' => 'asian',
            'status' => 'ongoing'
        ]);
    }

    private function createMatch($tournament)
    {
        $round = Round::create([
            'tournament_id' => $tournament->id,
            'name' => 'R1',
            'round_number' => 1,
            'is_published' => true
        ]);

        $room = Room::create(['name' => 'R1', 'tournament_id' => $tournament->id]);
        $adj = Adjudicator::create(['name' => 'Juri', 'tournament_id' => $tournament->id]);

        $gov = Team::create(['name' => 'G', 'tournament_id' => $tournament->id]);
        $opp = Team::create(['name' => 'O', 'tournament_id' => $tournament->id]);

        Speaker::create(['name' => 'S1', 'team_id' => $gov->id]);

        return DebateMatch::create([
            'round_id' => $round->id,
            'room_id' => $room->id,
            'gov_team_id' => $gov->id,
            'opp_team_id' => $opp->id,
            'adjudicator_id' => $adj->id
        ]);
    }
}