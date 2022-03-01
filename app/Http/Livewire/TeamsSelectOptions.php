<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TeamsSelectOptions extends Component
{
    public $teams;
    public $teamId;
    public $teamNumber;

    public function render()
    {
        return view('livewire.teams-select-options');
    }

    public function updatedTeamNumber()
    {
        Log::alert('changed: ' . $this->teamNumber);
        return redirect()->route('matches', ['teamNumber' => $this->teamNumber]);
    }
}
