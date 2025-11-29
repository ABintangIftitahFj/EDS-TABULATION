<?php

namespace App\Services;

use App\Models\Round;
use App\Models\DebateMatch;
use Illuminate\Support\Facades\Log;

class MatchmakingService
{
    /**
     * Generate round draw with Swiss or Random pairing
     * Includes conflict checking for same institution
     */
    public function generateRoundDraw(Round $round, $method = 'swiss')
    {
        $teams = $round->tournament->teams()->where('status', 'confirmed')->get();
        
        if ($teams->count() < 2) {
            throw new \Exception('Not enough teams to generate draw');
        }
        
        if ($teams->count() % 2 !== 0) {
            Log::warning("Odd number of teams ({$teams->count()}) - one team will have a bye");
        }
        
        $matches = collect();
        
        if ($method === 'swiss') {
            // Swiss System: Sort by total_vp, then total_speaker_score
            $teams = $teams->sortByDesc(function($team) {
                return [$team->total_vp ?? 0, $team->total_speaker_score ?? 0];
            })->values();
        } else {
            // Random pairing
            $teams = $teams->shuffle();
        }
        
        $paired = [];
        
        for ($i = 0; $i < $teams->count(); $i++) {
            if (in_array($i, $paired)) {
                continue;
            }
            
            $teamA = $teams[$i];
            $teamB = null;
            $partnerIndex = null;
            
            // Find best opponent
            for ($j = $i + 1; $j < $teams->count(); $j++) {
                if (in_array($j, $paired)) {
                    continue;
                }
                
                $potential = $teams[$j];
                
                // Avoid same institution if possible
                if ($teamA->institution !== $potential->institution) {
                    $teamB = $potential;
                    $partnerIndex = $j;
                    break;
                }
                
                // If no other option, pair with same institution
                if (!$teamB) {
                    $teamB = $potential;
                    $partnerIndex = $j;
                    Log::warning("Same institution pairing: {$teamA->name} ({$teamA->institution}) vs {$teamB->name} ({$teamB->institution})");
                }
            }
            
            if ($teamB) {
                $matches->push(DebateMatch::create([
                    'round_id' => $round->id,
                    'gov_team_id' => $teamA->id,
                    'opp_team_id' => $teamB->id,
                    'status' => 'scheduled',
                ]));
                
                $paired[] = $i;
                $paired[] = $partnerIndex;
            } else {
                // Bye round
                Log::info("Team {$teamA->name} gets a bye round");
            }
        }
        
        return $matches;
    }
}
