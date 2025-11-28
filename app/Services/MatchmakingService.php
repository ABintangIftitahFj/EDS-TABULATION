<?php

namespace App\Services;

use App\Models\Round;
use App\Models\DebateMatch;

class MatchmakingService
{
    public function generateRoundDraw(Round $round, $method = 'swiss')
    {
        $teams = $round->tournament->teams()->where('status', 'confirmed')->get();
        $matches = [];
        if ($method === 'swiss') {
            // Sort by total_vp, then total_speaker_score
            $teams = $teams->sortByDesc('total_vp')->sortByDesc('total_speaker_score')->values();
        } else {
            $teams = $teams->shuffle();
        }
        for ($i = 0; $i < $teams->count(); $i += 2) {
            if (isset($teams[$i+1])) {
                // Conflict checker: ensure teams from same institution are not paired
                if ($teams[$i]->institution === $teams[$i+1]->institution) {
                    // Try to swap with another team
                    for ($j = $i+2; $j < $teams->count(); $j++) {
                        if ($teams[$i]->institution !== $teams[$j]->institution) {
                            $temp = $teams[$i+1];
                            $teams[$i+1] = $teams[$j];
                            $teams[$j] = $temp;
                            break;
                        }
                    }
                }
                $matches[] = DebateMatch::create([
                    'round_id' => $round->id,
                    'gov_team_id' => $teams[$i]->id,
                    'opp_team_id' => $teams[$i+1]->id,
                    'status' => 'scheduled',
                ]);
            }
        }
        return $matches;
    }
}
