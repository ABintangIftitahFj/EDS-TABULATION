<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'format',
        'start_date',
        'end_date',
        'location',
        'status',
        'is_public',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_public' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    public function adjudicators()
    {
        return $this->hasMany(Adjudicator::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
