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


    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
