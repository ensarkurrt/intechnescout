<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchTeam extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_match_id',
        'team_id',
        'station'
    ];

    public function event_match()
    {
        return $this->belongsTo(EventMatch::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
