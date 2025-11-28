<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $fillable = [
        'round_id', 'room_id', 'adjudicator_id', 'gov_team_id', 'opp_team_id', 
        'winner_id', 'panel_judges', 'status', 'is_completed',
        'final_score_team_a', 'final_score_team_b', 'winner_team_id',
        'ballot_password', 'is_ballot_submitted'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'is_ballot_submitted' => 'boolean',
        'final_score_team_a' => 'decimal:2',
        'final_score_team_b' => 'decimal:2',
    ];

    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function adjudicator()
    {
        return $this->belongsTo(Adjudicator::class);
    }

    public function govTeam()
    {
        return $this->belongsTo(Team::class, 'gov_team_id');
    }

    public function oppTeam()
    {
        return $this->belongsTo(Team::class, 'opp_team_id');
    }

    public function winner()
    {
        return $this->belongsTo(Team::class, 'winner_id');
    }

    public function winnerTeam()
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class);
    }

    public function adjudicatorReviews()
    {
        return $this->hasMany(AdjudicatorReview::class);
    }

    /**
     * Calculate final scores from all adjudicator reviews
     */
    public function calculateFinalScores()
    {
        $reviews = $this->adjudicatorReviews;
        
        if ($reviews->isEmpty()) {
            return;
        }

        $this->final_score_team_a = $reviews->avg('score_team_a');
        $this->final_score_team_b = $reviews->avg('score_team_b');
        
        // Determine winner
        if ($this->final_score_team_a > $this->final_score_team_b) {
            $this->winner_team_id = $this->gov_team_id;
        } elseif ($this->final_score_team_b > $this->final_score_team_a) {
            $this->winner_team_id = $this->opp_team_id;
        }
        
        $this->status = 'finished';
        $this->save();
        
        // Update team records
        $this->updateTeamRecords();
    }

    /**
     * Update team win/loss records
     */
    protected function updateTeamRecords()
    {
        if (!$this->winner_team_id) {
            return;
        }

        $govTeam = $this->govTeam;
        $oppTeam = $this->oppTeam;

        if ($this->winner_team_id == $this->gov_team_id) {
            $govTeam->increment('total_wins');
            $oppTeam->increment('total_losses');
        } elseif ($this->winner_team_id == $this->opp_team_id) {
            $oppTeam->increment('total_wins');
            $govTeam->increment('total_losses');
        }
    }
}
