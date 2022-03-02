<?php

namespace App\Http\Livewire;

use App\Helpers\FRCHelper;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MatchList extends Component
{
    public $teamId;
    public $teamNumber;
    public $event;
    public $matches = [];
    public $orgMatches = [];

    public function mount()
    {
        $this->event = FRCHelper::get_event(null);
        $this->teams = $this->event->teams;
        $this->matches = $this->orgMatches = $this->event->matches;

        if ($this->teamId != null && $this->teamId != 0) {
            /* Optimized query */
            $this->matches = $this->matches->filter(function ($match) {
                return $match->teams()->where('team_id', $this->teamId)->exists();
            });
        }
    }
    public function render()
    {
        return view('livewire.match-list');
    }
}
