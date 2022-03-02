<?php

namespace App\Models;

use App\Casts\EncryptionCast;
use App\Helpers\CryptionHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team_id',
        'season_event_id',
        'weight',
        'height',
        'climb_level',
        'shoot_level',
        'score_per_match',
        'others',
    ];

    protected $casts = [
        'weight' => EncryptionCast::class,
        'height' => EncryptionCast::class,
        'climb_level' => EncryptionCast::class,
        'shoot_level' => EncryptionCast::class,
        'score_per_match' => EncryptionCast::class,
        'others' => EncryptionCast::class,
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
