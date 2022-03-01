<?php

namespace App\Http\Livewire;

use App\Helpers\FRCHelper;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Matches extends Component
{
    public $teamId;
    public $teamNumber;
    public $teams;

    public function mount()
    {
        $this->event = FRCHelper::get_event(null);

        /* $this->event = FRCHelper::get_season()->events()->where('event_id', FRCHelper::get_event_id())->first(); */
        $this->teams = $this->event->teams;
    }
    public function render()
    {
        return view('livewire.matches');
    }
    /*
    public function updatedTeamId()
    {
        return route('matches', ['teamId' => $this->teamId]);
    } */
}
