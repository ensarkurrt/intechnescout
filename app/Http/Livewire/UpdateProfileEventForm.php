<?php

namespace App\Http\Livewire;

use App\Helpers\FRCHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UpdateProfileEventForm extends Component
{

    public $season_event;
    public $season_events;
    public $current_event;

    public function mount()
    {

        $this->season_events = FRCHelper::get_season_events();
        $this->current_event = FRCHelper::get_event(null);
        /* dd($this->current_event); */
    }
    public function render()
    {
        return view('livewire.update-profile-event-form');
    }

    public function saveEvent()
    {
        /* Log::critical('saveEvent'); */
        /* Log::critical('$this->season_event: ' . $this->season_event); */
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->event_id = $this->season_event;
        FRCHelper::set_event_with_id($this->season_event);
        $user->save();

        return redirect()->route('teams');
    }
}
