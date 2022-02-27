<?php

namespace App\Http\Livewire;

use App\Models\Note;
use App\Models\Season;
use App\Models\Team;
use Livewire\Component;

class Teams extends Component
{
    public function render()
    {
        $teams = Season::where('year', date('Y'))->first()->events()->where('code', 'TUIS3')->first()->teams;
        return view('livewire.teams', compact('teams'));
    }
}
