<?php

namespace App\Http\Livewire;

use App\Helpers\FRCHelper;
use App\Models\Note;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Teams extends Component
{
    public function render()
    {
        /* dd(FRCHelper::get_event(null)); */
        $teams = FRCHelper::get_event(null)->teams;
        return view('livewire.teams', compact('teams'));
    }
}
