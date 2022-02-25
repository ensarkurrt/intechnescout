<?php

namespace App\Http\Livewire;

use App\Models\Note;
use App\Models\Team;
use Livewire\Component;

class Teams extends Component
{
    public function render()
    {
        $teams = Team::all();

        return view('livewire.teams', compact('teams'));
    }
}
