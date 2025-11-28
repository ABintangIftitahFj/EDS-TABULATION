<?php

namespace App\Services;

use App\Models\DebateMatch;
use App\Models\Ballot;
use Illuminate\Support\Facades\DB;

class BallotManagementService
{
    public function submitBallots($matchId, array $ballots)
    {
        DB::beginTransaction();
        try {
            foreach ($ballots as $ballotData) {
                Ballot::updateOrCreate([
                    'match_id' => $matchId,
                    'adjudicator_id' => $ballotData['adjudicator_id'],
                    'speaker_id' => $ballotData['speaker_id'],
                    'position' => $ballotData['position'],
                ], [
                    'score' => $ballotData['score'],
                    'team_role' => $ballotData['team_role'],
                    'is_reply' => $ballotData['is_reply'] ?? false,
                    'feedback' => $ballotData['feedback'] ?? null,
                ]);
            }
            DB::commit();
            return ['success' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
