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
        'start_date',
        'end_date',
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
        return $this->belongsToMany(MatchModel::class, 'season_event_matches');
    }

    /*  public function seasons()
    {
        return $this->belongsToMany(Season::class, 'season_events');
    } */

    public function seasons()
    {
        return $this->hasMany(SeasonEvent::class)->with('season');
    }
}
