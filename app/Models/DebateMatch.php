<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebateMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'round_id', 'room_id', 'adjudicator_id', 'gov_team_id', 'opp_team_id', 'winner_id', 'panel_judges', 'status', 'is_completed'
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

    public function winner()
    {
        return $this->belongsTo(Team::class, 'winner_id');
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class);
    }
}
