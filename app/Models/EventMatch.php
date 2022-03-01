<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_event_id',
        'match_id',
        'start_time',
    ];
    public function event()
    {
        return $this->belongsTo(SeasonEvet::class);
    }

    public function match()
    {
        return $this->belongsTo(MatchModel::class);
    }

    public function teams()
    {
        return $this->hasMany(MatchTeam::class, 'event_match_id', 'id');
    }
}
