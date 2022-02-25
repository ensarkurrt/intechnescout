<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotePhoto extends Component
{
    public $src;
    public function render()
    {
        return view('livewire.note-photo');
    }
}
