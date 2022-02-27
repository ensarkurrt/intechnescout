<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class TeamPhoto extends Component
{
    public $teamNumber;
    public function render()
    {
        if (!Storage::disk('public')->exists('media/teams/' . $this->teamNumber . '.png'))
            $this->teamNumber = 'not_found';
        return view('livewire.team-photo');
    }
}
