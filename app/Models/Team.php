<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'name',
        'institution',
        'total_vp',
        'total_speaker_score',
        'rank',
        'wins',
        'losses',
        'status'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function speakers()
    {
        return $this->hasMany('App\\Models\\Speaker');
    }

    public function matches()
    {
        return $this->hasMany('App\\Models\\DebateMatch', 'gov_team_id')->orWhere('opp_team_id', $this->id);
    }
}
