<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_event_id',
        'team_id',
    ];

    public function event()
    {
        return $this->belongsTo(SeasonEvet::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
