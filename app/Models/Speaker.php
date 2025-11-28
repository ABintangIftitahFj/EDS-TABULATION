<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id', 'name', 'total_score', 'speaker_rank'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class);
    }
}
