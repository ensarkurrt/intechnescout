<?php

namespace App\Http\Controllers;

use App\Enums\ApiPath;
use App\Models\Event;
use App\Models\Season;
use App\Models\SeasonEvent;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class FRCApiController extends Controller
{
    private static $curl;
    private static $httpHeader;
    private static $season;

    public function __construct()
    {
        self::$curl = curl_init();
        self::$httpHeader = array(
            'Authorization: Basic ' . base64_encode(env('FRC_API_USERNAME', 'ensarkurt') . ':' . env('FRC_API_KEY', "3324972d-d3a0-447d-9048-b34afc55ffe5")),
            'If-Modified-Since: '
        );
        self::$season = '2022'/* date("Y") */;
    }

    /*
        * Sending request using by curl to FRC API
        * @param string $apiPath: path of API
        * @param array $params: parameters of request
        * @return: response of API
    */
    static function send_request(string $apiPath = '', ?array $params): string
    {
        curl_setopt_array(self::$curl, array(
            CURLOPT_URL => 'https://frc-api.firstinspires.org/v3.0/' . self::$season . '/' . $apiPath . ($params != null ?  '?' . http_build_query($params) : ''),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => self::$httpHeader,
        ));
        $response = curl_exec(self::$curl);

        curl_close(self::$curl);
        return $response;
    }

    /*
        * @param array $params: [teamNumber, eventCode]
        * @return: array of events
    */
    static public function get_events(?array $params)
    {
        /* ['teamNumber' => $teamNumber] */
        return (new self)::send_request(ApiPath::Events, $params);
    }

    /*
        * @return: array of seasons
    */
    static public function get_season_summary()
    {
        return (new self)::send_request(ApiPath::SeasonSummary, null);
    }

    /*
        * @param array $params: [eventCode, teamNumber, page]
        * @return: array of teams
    */
    static public function get_teams(?array $params)
    {
        return (new self)::send_request(ApiPath::TeamListing, $params);
    }

    static private function get_images(?array $params)
    {
        $response = (new self)::send_request(ApiPath::TeamMedia, $params);
        if (!isset($response)) return [];
        $response = json_decode($response, true);
        $teams = [];
        $teams = $response['teams'];
        if ($response['pageCurrent'] < $response['pageTotal'])
            $teams = array_merge($teams, (new self)::get_images(['page' => $response['pageCurrent'] + 1]));
        return $teams;
    }


    static public function update_teams(): void
    {
        $season = Season::where('year', (new self)::$season)->get()->first();
        $events = $season->events;
        foreach ($events as $event) {
            $response = self::get_teams(['eventCode' => $event->code]);
            if (!isset($response)) return;
            $response = json_decode($response, true);
            $teams = $response['teams'];
            $team_ids = [];
            foreach ($teams as $team) {
                $teamModel = Team::where('number', $team['teamNumber'])->first();
                if (!$teamModel)
                    $teamModel = new Team();
                $teamModel->number = $team['teamNumber'];
                $teamModel->name = $team['nameShort'];
                $teamModel->save();
                $team_ids[] = $teamModel->id;
                $event->teams()->attach($teamModel, ['season_id' => $season->id]);
            }
        }
    }

    static public function update_images(): void
    {
        $teams = (new self)::get_images(/* ['eventCode' => 'TUIS3'] */null);
        foreach ($teams as $team) {
            if ($team['encodedAvatar'] == "" || $team['encodedAvatar'] == null) continue;
            $image = base64_decode($team['encodedAvatar']);
            $base_path      = 'media/teams/';
            $file_name      = $team['teamNumber'] . '.png';
            $url = '/storage/' . $base_path  . $file_name;
            file_put_contents(public_path() . $url, $image);
        }
    }

    static public function test(): void
    {
        $event = Event::find(156);
        $teams = $event->teams;
        dd($teams);
    }

    static public function update_events(): void
    {

        $response = self::get_events(null);
        if (!isset($response)) return;
        $response = json_decode($response, true);
        $current_season = Season::where('year', self::$season)->get()->first();
        $event_ids = [];
        foreach ($response['Events'] as $event) {
            $eventModel = Event::where('code', $event['code'])->first();
            if (!$eventModel)
                $eventModel = new Event();
            /* $eventModel->season_id = $current_season->id; */
            /* $eventModel->season_id = 1; */
            $eventModel->code = $event['code'];
            $eventModel->name = $event['name'];
            $eventModel->type = $event['type'];
            $eventModel->week_number = $event['weekNumber'];
            $eventModel->save();
            $event_ids[] = $eventModel->id;
        }

        $current_season->events()->syncWithoutDetaching($event_ids);
    }

    static public function update_season_summary(): void
    {
        $response = self::get_season_summary();
        if (!isset($response)) return;
        $response = json_decode($response, true);
        $_season = Season::where('year', self::$season)->get()->first();
        if ($_season == null)
            $_season = new Season();

        $_season->year = self::$season;
        $_season->name = $response['gameName'];
        $_season->team_count = $response['teamCount'];
        $_season->rookie_start = $response['rookieStart'];
        $_season->event_count = $response['eventCount'];
        $_season->save();
    }
}
