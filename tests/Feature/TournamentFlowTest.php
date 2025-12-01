<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Speaker;
use App\Models\Adjudicator;
use App\Models\Room;
use App\Models\Round;
use App\Models\DebateMatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_tournament_workflow()
    {
        // ==========================================
        // 1. PERSIAPAN DATA (SETUP)
        // ==========================================
        $admin = User::factory()->create(['is_admin' => true]);

        $tournament = Tournament::create([
            'name' => 'Laravel Cup 2025',
            'slug' => 'laravel-cup-2025', // Slug wajib diisi
            'format' => 'asian',
            'start_date' => now(),
            'end_date' => now()->addDays(3),
            'status' => 'ongoing'
        ]);

        // Siapkan Aset (Room, Adjudicator, Teams)
        $room = Room::create(['name' => 'Room 1', 'tournament_id' => $tournament->id]);
        $adj = Adjudicator::create(['name' => 'Chief Adj', 'tournament_id' => $tournament->id]);

        // Buat 2 Tim untuk Match
        $govTeam = Team::create(['name' => 'Gov Team', 'tournament_id' => $tournament->id]);
        $oppTeam = Team::create(['name' => 'Opp Team', 'tournament_id' => $tournament->id]);

        // Buat Speaker
        $govSpeakers = [
            Speaker::create(['name' => 'G1', 'team_id' => $govTeam->id]),
            Speaker::create(['name' => 'G2', 'team_id' => $govTeam->id]),
            Speaker::create(['name' => 'G3', 'team_id' => $govTeam->id]),
        ];
        $oppSpeakers = [
            Speaker::create(['name' => 'O1', 'team_id' => $oppTeam->id]),
            Speaker::create(['name' => 'O2', 'team_id' => $oppTeam->id]),
            Speaker::create(['name' => 'O3', 'team_id' => $oppTeam->id]),
        ];

        // ==========================================
        // 2. TEST FITUR "AUTO ADD ROUND" & NOTIFIKASI
        // ==========================================
        // Simulasi Admin klik tombol "Auto Add Round"
        // Perbaikan Route: rounds.auto-store -> admin.rounds.auto-store
        $responseRound = $this->actingAs($admin)
            ->post(route('admin.rounds.auto-store'), [
                'tournament_id' => $tournament->id
            ]);

        // Cek Redirect & Notifikasi Sukses
        $responseRound->assertRedirect();
        $responseRound->assertSessionHas('success');

        // Ambil ronde yang baru dibuat otomatis
        $round = Round::where('tournament_id', $tournament->id)->first();
        $this->assertNotNull($round, 'Round gagal dibuat otomatis.');

        // Kita manual set pairing karena auto-pairing logicnya kompleks, 
        // kita fokus test scoring & visibility di sini.
        $match = DebateMatch::create([
            'round_id' => $round->id,
            'room_id' => $room->id,
            'gov_team_id' => $govTeam->id,
            'opp_team_id' => $oppTeam->id,
            'adjudicator_id' => $adj->id
        ]);

        // Publish the draw so it's visible on public page
        $round->update(['is_draw_published' => true]);

        // ==========================================
        // 3. TEST VISIBILITY (HIDDEN SCORE)
        // ==========================================
        // Default: results_published = false. User harus lihat "VS", bukan Skor.

        $publicPage = $this->get(route('tournaments.matches', $tournament->id));
        $publicPage->assertStatus(200);
        $publicPage->assertSee('VS');
        $publicPage->assertDontSee('225'); // Pastikan skor belum bocor

        // ==========================================
        // 4. TEST INPUT BALLOT (SCORING)
        // ==========================================
        // Perbaikan Route: ballots.store -> admin.ballots.store
        $responseBallot = $this->actingAs($admin)
            ->post(route('admin.ballots.store', $match->id), [
                'scores' => [
                    $govSpeakers[0]->id => 75,
                    $govSpeakers[1]->id => 75,
                    $govSpeakers[2]->id => 75,
                    $oppSpeakers[0]->id => 70,
                    $oppSpeakers[1]->id => 70,
                    $oppSpeakers[2]->id => 70,
                ],
                'reply_scores' => [
                    $govTeam->id => 36,
                    $oppTeam->id => 35
                ]
            ]);

        $responseBallot->assertSessionHas('success'); // Notifikasi sukses input nilai

        // Cek Database apakah nilai masuk & pemenang terhitung
        $this->assertDatabaseHas('matches', [
            'id' => $match->id,
            'winner_id' => $govTeam->id, // Gov (261) vs Opp (245)
            'is_completed' => true
        ]);

        // Cek Halaman Publik Lagi (Harusnya ada badge "BALLOT FILLED", tapi skor masih Hidden)
        $publicPageAfterScore = $this->get(route('tournaments.matches', $tournament->id));
        $publicPageAfterScore->assertSee('BALLOT FILLED');
        $publicPageAfterScore->assertDontSee('261'); // Skor Gov masih rahasia

        // ==========================================
        // 5. TEST TOGGLE VISIBILITY (UNLOCK SCORE)
        // ==========================================
        // Simulasi Admin klik tombol "Show Speaker Score"
        // Perbaikan Route: rounds.toggle-results -> admin.rounds.toggle-results
        // Berdasarkan instruksi sebelumnya, ini ada di dalam group admin.
        $responseToggle = $this->actingAs($admin)
            ->post(route('admin.rounds.toggle-results', $round->id));

        $responseToggle->assertSessionHas('success'); // Notifikasi sukses toggle

        // Cek Halaman Publik (Sekarang skor harus muncul)
        $publicPagePublished = $this->get(route('tournaments.matches', $tournament->id));
        $publicPagePublished->assertSee('261'); // Skor Gov muncul
        $publicPagePublished->assertSee('245'); // Skor Opp muncul
    }
}