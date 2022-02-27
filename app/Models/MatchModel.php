<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory;

    protected $fillable = [
        /* 'description', */
        'tourtament_level',
        'start_time',
        'match_number',
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'match_teams');
    }

    public function event()
    {
        return $this->belongsToMany(Event::class, 'season_event_matches');
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
