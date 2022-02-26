<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'week_number',
        'type',
    ];

    /*  public function teams()
    {
        return $this->belongsToMany(Team::class, 'event_team');
    } */

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'season_event_teams');
    }

    public function matches()
    {
        return $this->belongsToMany(MatchModel::class, 'event_matches')->withPivot('season_id');
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'season_events')->withPivot('team_id');
    }
}
