<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Team extends Model
{
    use HasFactory;

    protected $appends = array('isInspected', 'note');

    public function getIsInspectedAttribute()
    {
        return $this->note != null && $this->note->weight != null;
    }

    public function getNoteAttribute()
    {
        return $this->notes()->where('user_id', auth()->id())->first();
    }

    /* public function season_events()
    {
        return $this->belongsToMany(SeasonEvents::class, 'season_event_teams');
    } */

    public function events()
    {
        return $this->belongsToMany(Event::class, 'season_event_teams')->withPivot('season_id');
    }

    public function matches()
    {
        return $this->belongsToMany(MatchTeam::class, 'match_teams');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
