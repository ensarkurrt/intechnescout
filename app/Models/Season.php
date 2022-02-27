<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'team_count',
        'rookie_start',
        'event_count',
        'season_id',
        /* 'kick_off', */
    ];

    /* public function season()
    {
        return $this->belongsTo(Season::class);
    } */

    public function events()
    {
        return $this->belongsToMany(Event::class, 'season_events');
    }

    public function matches()
    {
        return $this->hasMany(MatchModel::class);
    }
}
