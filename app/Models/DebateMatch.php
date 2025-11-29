<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebateMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'round_id',
        'room_id',
        'adjudicator_id',
        'gov_team_id',
        'opp_team_id',
        'cg_team_id',
        'co_team_id',
        'gov_rank',
        'opp_rank',
        'cg_rank',
        'co_rank',
        'winner_id',
        'panel_judges',
        'status',
        'is_completed',
        'gov_reply_score',
        'opp_reply_score'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
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

    public function cgTeam()
    {
        return $this->belongsTo(Team::class, 'cg_team_id');
    }

    public function coTeam()
    {
        return $this->belongsTo(Team::class, 'co_team_id');
    }

    public function winner()
    {
        return $this->belongsTo(Team::class, 'winner_id');
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class, 'match_id');
    }

    public function adjudicatorReviews()
    {
        return $this->hasMany(AdjudicatorReview::class, 'match_id');
    }
}
