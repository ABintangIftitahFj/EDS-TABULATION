<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function getMatchHistory(Team $team)
    {
        // Get all matches where this team participated
        $matches = $team->matches()
            ->with([
                'round',
                'room',
                'govTeam',
                'oppTeam',
                'cgTeam',
                'coTeam',
                'adjudicator',
                'ballots'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $history = $matches->map(function ($match) use ($team) {
            $isGov = $match->gov_team_id === $team->id;
            $isOpp = $match->opp_team_id === $team->id;
            $isCg = $match->cg_team_id === $team->id;
            $isCo = $match->co_team_id === $team->id;

            // Determine position
            $position = 'Unknown';
            if ($isGov)
                $position = 'Government';
            elseif ($isOpp)
                $position = 'Opposition';
            elseif ($isCg)
                $position = 'Closing Government';
            elseif ($isCo)
                $position = 'Closing Opposition';

            // Determine opponent(s)
            $opponents = [];
            if ($isGov || $isCg) {
                if ($match->oppTeam)
                    $opponents[] = $match->oppTeam->name;
                if ($match->coTeam)
                    $opponents[] = $match->coTeam->name;
            } else {
                if ($match->govTeam)
                    $opponents[] = $match->govTeam->name;
                if ($match->cgTeam)
                    $opponents[] = $match->cgTeam->name;
            }

            // Get result
            $result = 'Not Scored';
            $teamScore = null;

            if ($match->ballots->isNotEmpty()) {
                $ballot = $match->ballots->first();

                // Determine winner
                if ($match->winner_team_id) {
                    $result = $match->winner_team_id === $team->id ? '🏆 Win' : '❌ Loss';
                }

                // Get team score
                $teamSpeakers = $team->speakers->pluck('id')->toArray();
                $teamScore = $ballot->speakerScores()
                    ->whereIn('speaker_id', $teamSpeakers)
                    ->sum('score');
            }

            return [
                'match_id' => $match->id,
                'round_name' => $match->round->name ?? 'Unknown Round',
                'room_name' => $match->room->name ?? 'TBA',
                'position' => $position,
                'opponents' => implode(' vs ', $opponents),
                'adjudicator' => $match->adjudicator->name ?? 'TBA',
                'result' => $result,
                'team_score' => $teamScore,
                'status' => $match->status,
                'has_ballot' => $match->ballots->isNotEmpty(),
            ];
        });

        return response()->json([
            'success' => true,
            'team' => [
                'id' => $team->id,
                'name' => $team->name,
                'emoji' => $team->emoji ?? '👥',
                'institution' => $team->institution,
            ],
            'matches' => $history,
            'total_matches' => $history->count(),
        ]);
    }
}
