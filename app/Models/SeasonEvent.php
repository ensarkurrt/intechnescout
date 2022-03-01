<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'event_id',
    ];

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function teams()
    {
        return $this->hasMany(EventTeam::class, 'season_event_id', 'id');
    }

    public function matches()
    {
        return $this->hasMany(EventMatch::class, 'season_event_id', 'id');
    }

    /* public function season()
    {
        return $this->hasMany(Season::class);
    } */
}
