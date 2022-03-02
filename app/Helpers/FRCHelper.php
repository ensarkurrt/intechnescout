<?php

namespace App\Helpers;

use App\Models\Event;
use App\Models\Season;
use App\Models\SeasonEvent;
use Illuminate\Support\Facades\Session;

class FRCHelper
{
    static function get_season()
    {
        $season =  Season::where('year', config('frc.season') ?? date('Y'))->first();
        if (!$season) return abort(8166, 'The WebSite is not configured to use the current season.');
        return $season;
    }

    static function get_season_year(): int
    {
        $season = (new self)::get_season();
        if (!$season) return config('frc.season') ?? date('Y');
        return  $season->year;
    }

    static function get_season_events()
    {
        return FRCHelper::get_season()->events;
    }
    static function get_event_id()
    {
        $response = Session::get('event_id', auth()->user() != null ? auth()->user()->event_id : null);
        if (!$response) {
            $response = auth()->user() != null ? auth()->user()->event_id : null;
        }
        if (!(new self)::get_event($response))
            $response = null;
        return $response;
    }

    static function get_event(?string $id)
    {
        return (new self)::get_season_events()->find($id ?? FRCHelper::get_event_id());
    }

    static function set_event_with_code(string $code)
    {
        $event = Event::where('code', $code)->first();
        if (!$event) return;
        $_event = (new self)::get_season_events()->find($event->id)->first();
        if (!$_event) return;
        Session::put('event_id', $_event->id);
    }

    static function set_event_with_id(int $id)
    {
        $event = (new self)::get_event($id);
        if (!$event) return;
        Session::put('event_id', $event->id);
    }
}
