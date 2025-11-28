<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Speaker;
use App\Models\Adjudicator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Room;
use App\Models\Round;
use App\Models\Motion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TournamentDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Modern tournament name
        $slug = Str::slug('Neon Nexus Cup');
        $t = Tournament::updateOrCreate([
            'slug' => $slug,
        ], [
            'name' => 'Neon Nexus Cup',
            'format' => 'asian_par',
            'start_date' => now(),
            'end_date' => now()->addDays(2),
            'location' => 'Virtual Arena',
            'status' => 'ongoing',
            'is_public' => true,
            'settings' => ['type' => 'individual']
        ]);

        // If tournament already existed, clean previous related data to avoid duplicates
        if (! $t->wasRecentlyCreated) {
            $t->rounds()->delete();
            $t->teams()->delete();
            $t->adjudicators()->delete();
            $t->rooms()->delete();
        }

        // Institutions pool
        $institutions = [
            'Metro University',
            'Nova Institute',
            'Aurora College',
            'Pacifica Academy',
            'Vertex State',
            'Horizon Tech'
        ];

        // Create 30 individual participants as Teams with 1 Speaker each
        $teams = [];
        for ($i = 1; $i <= 30; $i++) {
            $inst = $institutions[array_rand($institutions)];
            $team = Team::create([
                'tournament_id' => $t->id,
                'name' => "Team {$i} — {$inst}",
                'institution' => $inst,
                'total_vp' => 0,
                'total_speaker_score' => 0,
                'rank' => 0,
                'wins' => 0,
                'losses' => 0,
                'status' => 'confirmed'
            ]);

            Speaker::create([
                'team_id' => $team->id,
                'name' => "Speaker {$i}",
                'total_score' => 0,
                'speaker_rank' => 0,
            ]);

            $teams[] = $team;
        }

        // Create 6 adjudicators (create a user per adjudicator)
        $adjudicators = [];
        for ($j = 1; $j <= 6; $j++) {
            $u = User::updateOrCreate([
                'email' => "judge{$j}@example.com",
            ], [
                'name' => "JudgeUser {$j}",
                'password' => Hash::make('secret'),
            ]);

            $adj = Adjudicator::create([
                'tournament_id' => $t->id,
                'user_id' => $u->id,
                'name' => "Judge {$j}",
                'institution' => $institutions[array_rand($institutions)],
                'is_available' => true,
                'level' => 'panelist',
                'rating' => 0,
            ]);
            $adjudicators[] = $adj;
        }

        // Create 6 rooms
        $rooms = [];
        for ($r = 1; $r <= 6; $r++) {
            $room = Room::create([
                'tournament_id' => $t->id,
                'name' => "Room {$r}",
                'location' => 'Online',
                'is_active' => true,
                'capacity' => 10,
            ]);

            $rooms[] = $room;
        }

        // Helper to create a round and pair teams into matches
        $createRound = function ($roundName, &$teamsList, $rooms, $adjudicators) use ($t) {
            $motionText = "{$roundName} Motion: This house would prioritize sustainable innovation in urban planning.";
            $round = Round::create([
                'tournament_id' => $t->id,
                'name' => $roundName,
                'motion' => $motionText,
                'info_slide' => null,
                'is_published' => true,
                'is_motion_published' => true,
                'status' => 'completed',
                'start_time' => now(),
            ]);

            // shuffle and pair
            $shuffled = $teamsList;
            shuffle($shuffled);

            $roomCount = count($rooms);
            $adjCount = count($adjudicators);
            $matches = [];

            for ($i = 0; $i < count($shuffled); $i += 2) {
                if (!isset($shuffled[$i+1])) {
                    // bye - single team advances
                    $winner = $shuffled[$i];
                    $winner->wins += 1;
                    $winner->save();
                    continue;
                }

                $teamA = $shuffled[$i];
                $teamB = $shuffled[$i+1];

                $room = $rooms[(int)(($i/2) % $roomCount)];
                $adj = $adjudicators[(int)(($i/2) % $adjCount)];

                // random winner
                $winnerTeam = (rand(0,1) === 0) ? $teamA : $teamB;
                $loserTeam = ($winnerTeam->id === $teamA->id) ? $teamB : $teamA;

                $m = DB::table('matches')->insertGetId([
                    'round_id' => $round->id,
                    'room_id' => $room->id,
                    'adjudicator_id' => $adj->id,
                    'gov_team_id' => $teamA->id,
                    'opp_team_id' => $teamB->id,
                    'winner_id' => $winnerTeam->id,
                    'panel_judges' => null,
                    'status' => 'completed',
                    'is_completed' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // create ballots for both speakers (individual format: 1 speaker per team)
                $govSpeaker = Speaker::where('team_id', $teamA->id)->first();
                $oppSpeaker = Speaker::where('team_id', $teamB->id)->first();
                if ($govSpeaker) {
                    DB::table('ballots')->insert([
                        'match_id' => $m,
                        'adjudicator_id' => $adj->id,
                        'speaker_id' => $govSpeaker->id,
                        'score' => rand(60,85),
                        'team_role' => 'gov',
                        'position' => '1',
                        'is_reply' => false,
                        'feedback' => 'Good points and structure.',
                        'is_consensus' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                if ($oppSpeaker) {
                    DB::table('ballots')->insert([
                        'match_id' => $m,
                        'adjudicator_id' => $adj->id,
                        'speaker_id' => $oppSpeaker->id,
                        'score' => rand(55,80),
                        'team_role' => 'opp',
                        'position' => '1',
                        'is_reply' => false,
                        'feedback' => 'Persuasive rebuttal and examples.',
                        'is_consensus' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // update wins/losses
                $winnerTeam->wins += 1;
                $winnerTeam->save();

                $loserTeam->losses += 1;
                $loserTeam->save();

                $matches[] = $m;
            }

            return $matches;
        };

        // Create 4 prelim rounds
        for ($p = 1; $p <= 4; $p++) {
            $createRound("Prelim {$p}", $teams, $rooms, $adjudicators);
        }

        // After prelims, pick top 4 by wins
        $topTeams = Team::where('tournament_id', $t->id)
            ->orderByDesc('wins')
            ->limit(4)
            ->get()
            ->values();

        // Semifinals (2 matches)
        $semi = Round::create([
            'tournament_id' => $t->id,
            'name' => 'Semi Final',
            'status' => 'completed',
            'start_time' => now(),
        ]);

        $semiWinners = [];
        if ($topTeams->count() >= 4) {
            $pairs = [[$topTeams[0], $topTeams[3]], [$topTeams[1], $topTeams[2]]];
            foreach ($pairs as $idx => $pair) {
                $room = $rooms[$idx % count($rooms)];
                $adj = $adjudicators[$idx % count($adjudicators)];
                $winner = (rand(0,1) === 0) ? $pair[0] : $pair[1];

                $mid = DB::table('matches')->insertGetId([
                    'round_id' => $semi->id,
                    'room_id' => $room->id,
                    'adjudicator_id' => $adj->id,
                    'gov_team_id' => $pair[0]->id,
                    'opp_team_id' => $pair[1]->id,
                    'winner_id' => $winner->id,
                    'status' => 'completed',
                    'is_completed' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // ballots for semifinal
                $govSpeaker = Speaker::where('team_id', $pair[0]->id)->first();
                $oppSpeaker = Speaker::where('team_id', $pair[1]->id)->first();
                if ($govSpeaker) {
                    DB::table('ballots')->insert([
                        'match_id' => $mid,
                        'adjudicator_id' => $adj->id,
                        'speaker_id' => $govSpeaker->id,
                        'score' => rand(65,88),
                        'team_role' => 'gov',
                        'position' => '1',
                        'is_reply' => false,
                        'feedback' => 'Strong casebuilding.',
                        'is_consensus' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                if ($oppSpeaker) {
                    DB::table('ballots')->insert([
                        'match_id' => $mid,
                        'adjudicator_id' => $adj->id,
                        'speaker_id' => $oppSpeaker->id,
                        'score' => rand(60,85),
                        'team_role' => 'opp',
                        'position' => '1',
                        'is_reply' => false,
                        'feedback' => 'Clear rebuttal.',
                        'is_consensus' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $winner->wins += 1;
                $winner->save();
                $semiWinners[] = $winner;
            }
        }

        // Grand Final
        if (count($semiWinners) >= 2) {
            $final = Round::create([
                'tournament_id' => $t->id,
                'name' => 'Grand Final',
                'status' => 'completed',
                'start_time' => now(),
            ]);

            $room = $rooms[0];
            $adj = $adjudicators[0];
            $winner = (rand(0,1) === 0) ? $semiWinners[0] : $semiWinners[1];

            $fid = DB::table('matches')->insertGetId([
                'round_id' => $final->id,
                'room_id' => $room->id,
                'adjudicator_id' => $adj->id,
                'gov_team_id' => $semiWinners[0]->id,
                'opp_team_id' => $semiWinners[1]->id,
                'winner_id' => $winner->id,
                'status' => 'completed',
                'is_completed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ballots for final
            $govSpeaker = Speaker::where('team_id', $semiWinners[0]->id)->first();
            $oppSpeaker = Speaker::where('team_id', $semiWinners[1]->id)->first();
            if ($govSpeaker) {
                DB::table('ballots')->insert([
                    'match_id' => $fid,
                    'adjudicator_id' => $adj->id,
                    'speaker_id' => $govSpeaker->id,
                    'score' => rand(70,92),
                    'team_role' => 'gov',
                    'position' => '1',
                    'is_reply' => false,
                    'feedback' => 'Final-level performance.',
                    'is_consensus' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if ($oppSpeaker) {
                DB::table('ballots')->insert([
                    'match_id' => $fid,
                    'adjudicator_id' => $adj->id,
                    'speaker_id' => $oppSpeaker->id,
                    'score' => rand(68,90),
                    'team_role' => 'opp',
                    'position' => '1',
                    'is_reply' => false,
                    'feedback' => 'Compelling rebuttal and impact.',
                    'is_consensus' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $winner->wins += 1;
            $winner->save();
        }

        // Compute and store realistic totals for each team and speakers based on ballots
        $allTeams = Team::where('tournament_id', $t->id)->get();
        foreach ($allTeams as $team) {
            // VP: 3 points per win
            $vp = $team->wins * 3;

            // Speaker score: sum of ballot scores for speakers in this team
            $speakerScore = DB::table('ballots')
                ->join('speakers', 'ballots.speaker_id', '=', 'speakers.id')
                ->where('speakers.team_id', $team->id)
                ->sum('ballots.score');

            $team->total_vp = $vp;
            $team->total_speaker_score = $speakerScore;
            $team->save();

            // Update each speaker total_score
            $speakers = Speaker::where('team_id', $team->id)->get();
            foreach ($speakers as $sp) {
                $sTotal = DB::table('ballots')->where('speaker_id', $sp->id)->sum('score');
                $sp->total_score = $sTotal;
                $sp->save();
            }
        }

        // Create motions for each round
        $allRounds = Round::where('tournament_id', $t->id)->get();
        $sampleMotions = [
            [
                'title' => 'This House would prioritize environmental sustainability over economic growth',
                'detail' => 'In developing nations facing immediate economic challenges, governments should still place environmental policies above short-term economic gains.',
                'category' => 'Environment & Economics',
                'info_slide' => 'Consider: climate change impacts, developing vs developed nations, generational equity, sustainable development goals',
            ],
            [
                'title' => 'This House believes that social media platforms should be held legally responsible for harmful content posted by users',
                'detail' => 'Platforms like Facebook, Twitter, and TikTok should face criminal and civil liability for violent, hateful, or misleading content shared by their users.',
                'category' => 'Technology & Law',
                'info_slide' => 'Section 230 protection debate, content moderation challenges, free speech concerns',
            ],
            [
                'title' => 'This House would abolish all immigration restrictions between countries',
                'detail' => 'Nation states should allow complete freedom of movement across borders without visas, permits, or quotas.',
                'category' => 'Immigration & Sovereignty',
                'info_slide' => 'Global inequality, brain drain, cultural integration, security concerns',
            ],
            [
                'title' => 'This House believes that governments should implement universal basic income',
                'detail' => 'All citizens should receive a regular unconditional cash payment from the government, regardless of employment status.',
                'category' => 'Economic Policy',
                'info_slide' => 'Automation impact, poverty reduction, work incentives, funding mechanisms',
            ],
            [
                'title' => 'This House would ban private ownership of essential resources (water, energy, healthcare)',
                'detail' => 'Critical infrastructure and services necessary for human survival should be publicly owned and operated.',
                'category' => 'Public vs Private Sector',
                'info_slide' => 'Efficiency concerns, equity of access, infrastructure investment, corruption risks',
            ],
            [
                'title' => 'This House believes in the use of artificial intelligence to make criminal sentencing decisions',
                'detail' => 'Courts should use AI algorithms to determine appropriate sentences for convicted criminals, removing human judges from sentencing.',
                'category' => 'Justice & AI',
                'info_slide' => 'Algorithmic bias, consistency, rehabilitation vs punishment, judicial discretion',
            ],
        ];

        foreach ($allRounds as $index => $round) {
            $motionData = $sampleMotions[$index % count($sampleMotions)];
            Motion::create([
                'round_id' => $round->id,
                'title' => $motionData['title'],
                'detail' => $motionData['detail'],
                'category' => $motionData['category'],
                'info_slide' => $motionData['info_slide'],
                'is_released' => true,
                'released_at' => $round->start_time ?? now(),
            ]);
        }
    }
}
