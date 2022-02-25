<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NoteAlbum extends Component
{
    public $photos;
    public $tempPhotos;

    public function render()
    {
        return view('livewire.note-album');
    }
}
