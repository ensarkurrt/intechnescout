<?php

namespace App\Http\Livewire;

use App\Models\NotePhoto;
use App\Models\Note as NoteModel;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\ErrorHandler\Debug;

class Note extends Component
{
    use WithFileUploads;

    public $team_id;
    public $team_number;
    public $weight;
    public $height;
    public $climb_level;
    public $shoot_level;
    public $score_per_match;
    public $others;
    public $photos = [];
    public $shownPhotos = [];
    public $note;
    public $show = true;
    public $removedPhotos = [];



    public function mount()
    {

        $this->note = NoteModel::where('team_id', $this->team_id)->where('user_id', auth()->id())->with('photos')->get()->first();

        if ($this->note == null)
            $this->note = NoteModel::create([
                'team_id' => $this->team_id,
                'user_id' => auth()->id(),
            ]);

        $this->weight = $this->note->weight ?? null;
        $this->height = $this->note->height ?? null;
        $this->climb_level = $this->note->climb_level ?? null;
        $this->shoot_level = $this->note->shoot_level ?? null;
        $this->score_per_match = $this->note->score_per_match ?? null;
        $this->others = $this->note->others ?? null;
        foreach ($this->note->photos as $photo) {
            $this->shownPhotos[] = $photo->path;
        }
    }

    protected $rules = [
        'weight' => 'required|numeric|min:0',
        'height' => 'required|numeric|min:0',
        'shoot_level' => 'required|numeric|min:0|max:4',
        'climb_level' => 'required|numeric|min:0|max:4',
        'score_per_match' => 'required|numeric|min:0',
        'others' => 'required|string',
        /* 'photos.*' => 'image|max:2048', */
    ];

    public function render()
    {
        return view('livewire.note');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveNote()
    {
        /* INFO:: Running when click save button on Note Component */
        if ($this->note->user_id != auth()->id())
            abort(403);

        $this->validate();

        $this->note->update([
            'weight' => $this->weight,
            'height' => $this->height,
            'climb_level' => $this->climb_level,
            'shoot_level' => $this->shoot_level,
            'score_per_match' => $this->score_per_match,
            'others' => $this->others,
        ]);

        if ($this->photos != null)
            $this->save_photo();

        if ($this->removedPhotos != null)
            $this->remove_photo();
    }

    public function remove_photo()
    {
        /* INFO:: Remove images from local storage.*/
        foreach ($this->removedPhotos as $photo) {
            $tempFileName = str_replace("storage/", '', $photo[1]);
            if (Storage::disk('public')->exists($tempFileName)) {
                Storage::disk('public')->delete($tempFileName);
                NotePhoto::where('id', $photo[0])->get()->first()->delete();
            }
        }
    }

    /* INFO:: Root copier for temp files.
    The uploader component creates temp image files when upload.
    And then the save_photo function, manage the images is array or single. */
    public function save_photo()
    {
        $paths = [];
        $photos = $this->photos;

        if (is_array($photos)) {
            foreach ($photos as $photo) {
                if ($photo->exists())
                    $paths[] = $this->move_photo($photo);
            }
        } else {
            if ($photos->exists())
                $paths[] = $this->move_photo($photos);
        }
    }

    public function removeUpload($fieldName, $fileName): void
    {
        $tempFileName = str_replace("storage/", '', $fileName);

        /* INFO:: If the file which want to delete is local file,
        record them for delete when saving the form. If it is temp file, delete it. */
        if (Storage::disk('public')->exists($tempFileName)) {
            $photo = NotePhoto::where('path', $fileName)->get()->first();
            if ($photo) {
                $this->removedPhotos[] = [$photo->id, $photo->path];
            }
        } else
            Storage::disk('lw-tmp')->delete($fileName);
    }

    /*INFO:: Move images from temp to local */
    private function move_photo($photo)
    {
        $file_extension = $photo->getClientOriginalExtension();
        $base_path      = $this->get_path($file_extension);
        $file_name      = Str::orderedUuid() . '.' . $file_extension;
        $url = 'storage/' . $base_path . '/' . $file_name;
        $photo->storeAs($base_path, $file_name, 'public');
        NotePhoto::create([
            'note_id' => $this->note->id,
            'path' => $url,
        ]);

        /* INFO:: Delete temp image after copy that to local */
        $photo->delete();
        return $url;
    }

    private function get_path(string $extension): string
    {
        return "media/robots";
    }
}
