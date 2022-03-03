<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class CustomController extends Controller
{
    public function matches($teamNumber = null)
    {
        $teamId = null;

        if ($teamNumber != null && $teamNumber != 0) {
            $team = Team::where('number', $teamNumber)->first();
            if (!$team) {
                abort(404);
            }
            $teamId = $team->id;
        }

        return view('matches', compact('teamId', 'teamNumber'));
    }

    public function teams()
    {
        return view('teams');
    }

    public function save_event()
    {
        return view('save-event');
    }

    public function encryption_md()
    {
        $encryptionFile = Jetstream::localizedMarkdownPath('encryption.md');

        return view('encryption', [
            'encryption' => Str::markdown(file_get_contents($encryptionFile)),
        ]);
    }
}
