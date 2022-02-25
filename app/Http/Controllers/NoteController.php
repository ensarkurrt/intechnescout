<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteImageDeleteRequest;
use App\Http\Requests\NoteImageUploadRequest;
use App\Models\Note;
use App\Models\NotePhoto;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    public function detail($teamId)
    {
        $team = Team::where('number', $teamId)->first();
        if (!$team) {
            abort(404);
        }
        return view('note.index', compact('team'));
    }
    /*
    public function upload_photos(NoteImageUploadRequest $request,  $id)
    {
        $note = Note::find($id);
        if ($note->user_id != auth()->id()) {
            abort(403);
        }
        $paths = [];
        $photos = $request->file('photos');
        if (is_array($photos)) {
            foreach ($photos as $photo)
                $paths[] = $this->upload($photo, $id);
        } else
            $path = $this->upload($photos, $id);

        return response()->json(['path' => $path]);
    }

    public function delete_photo($id)
    {
        $reqPath = json_decode(request()->getContent(), true)['path'];

        if (!$reqPath)
            abort(400);
        $note = Note::find($id);
         if ($note->user_id != auth()->id()) {
            abort(403);
        }
        $photo = NotePhoto::where('path', $reqPath)->get()->first();
        if (!$photo)
            abort(404);
        $photo->delete();
        $path = str_replace('storage/', '', $reqPath);
        unlink(public_path($reqPath));
    }

    public function showToken()
    {
        echo csrf_token();
    }

    private function upload($photo, $note_id)
    {
        $file_extension = $photo->getClientOriginalExtension();
        $base_path      = $this->get_path($file_extension);
        $file_name      = Str::orderedUuid() . '.' . $file_extension;
        $url = 'storage/' . $base_path . '/' . $file_name;
        $photo->storeAs($base_path, $file_name, 'public');

        NotePhoto::create([
            'note_id' => $note_id,
            'path' => $url,
        ]);
        return $url;
    }

    private function get_path(string $extension): string
    {
        $base_folder = 'media';
        return "$base_folder/robots";
    } */
}
