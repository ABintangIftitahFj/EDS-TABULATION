<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'name',
        'round_number',
        'motion',
        'info_slide',
        'is_published',
        'is_motion_published',
        'is_draw_published',
        'draw_published_at',
        'motion_published_at',
        'status',
        'start_time',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_motion_published' => 'boolean',
        'is_draw_published' => 'boolean',
        'start_time' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'draw_published_at' => 'datetime',
        'motion_published_at' => 'datetime',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function matches()
    {
        return $this->hasMany('App\\Models\\DebateMatch');
    }

    public function motions()
    {
        return $this->hasMany(Motion::class);
    }
}
