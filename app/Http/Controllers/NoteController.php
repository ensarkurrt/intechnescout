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
    public function api_test()
    {
        /* FRCApiController::update_season_summary();
        FRCApiController::update_events(); */
        /* FRCApiController::update_teams(); */
    }
}
