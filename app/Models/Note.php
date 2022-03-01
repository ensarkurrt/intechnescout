<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team_id',
        'season_id',
        'weight',
        'height',
        'climb_level',
        'shoot_level',
        'score_per_match',
        'others',
    ];

    public function photos()
    {
        return $this->hasMany(NotePhoto::class);
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
