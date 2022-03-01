<?php

namespace App\Http\Controllers;

use App\Enums\ApiPath;
use App\Helpers\FRCHelper;
use App\Models\Event;
use App\Models\MatchModel;
use App\Models\Season;
use App\Models\SeasonEvent;
use App\Models\EventTeam;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
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
        self::$season = FRCHelper::get_season_year();
        /* dd(self::$season); */
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
        * Get events summary from FRC API
        * @param array $params: [teamNumber, eventCode]
        * @param bool $parseJson: parse json or not
        * @return: array of events
    */
    static public function get_events(?array $params, ?bool $parseJson = false)
    {
        $response = (new self)::send_request(ApiPath::Events, $params);
        return $parseJson != null && $parseJson == true ? json_decode($response, true) : $response;
    }

    /*
        * Get Season Summary from FRC API
        * @param bool $parseJson: parse json or not
        * @return: array of seasons
    */
    static public function get_season_summary(?bool $parseJson = false)
    {
        $response = (new self)::send_request(ApiPath::SeasonSummary, null);
        return $parseJson != null && $parseJson == true ? json_decode($response, true) : $response;
    }

    /*
        * @param array $params: [eventCode, teamNumber, page]
        * @param bool $parseJson: parse json or not
        * @return: array of teams
    */
    static public function get_teams(?array $params, ?bool $parseJson = false)
    {
        $response = (new self)::send_request(ApiPath::TeamListing, $params);
        return $parseJson != null && $parseJson == true ? json_decode($response, true) : $response;
    }

    /*
        * @param array $eventCode: code of specified event
        * @param array $params: [tournamentLevel = qual | playoff, ?teamNumber, ?start, ?end]
    */
    static public function get_event_matches(string $eventCode, ?array $params, ?bool $parseJson = false)
    {
        $response = (new self)::send_request(ApiPath::EventMatches . $eventCode, $params);
        return $parseJson != null && $parseJson == true ? json_decode($response, true) : $response;
    }

    static public function get_images(?array $params): ?array
    {
        $response = (new self)::send_request(ApiPath::TeamMedia, $params);
        if (!isset($response)) return [];
        $response = json_decode($response, true);
        $teams = [];
        $teams = $response['teams'];
        /* Unset page parameters because of page parameters will add or increase at the end */
        if ($params != null && $params['page'] != null)
            unset($params['page']);
        if ($response['pageCurrent'] < $response['pageTotal'])
            $teams = array_merge($teams, (new self)::get_images(array_merge($params ?? [], ['page' => $response['pageCurrent'] + 1])));
        return $teams;
    }

    static public function update_event_matches(): void
    {
        $season = Season::where('year', (new self)::$season)->get()->first();
        $events = $season->events;
        foreach ($events as $event) {
            $matches = (new self)::get_event_matches($event->event->code, ['tournamentLevel' => 'qual'], true)['Schedule'];
            if ($matches == null || count($matches) == 0) continue;
            $match_ids = [];
            foreach ($matches as $match) {
                $matchModel = MatchModel::where('tournament_level', $match['tournamentLevel'])->where('match_number', $match['matchNumber'])->first();
                if (!$matchModel)
                    $matchModel = new MatchModel();
                /* $matchModel->event_id = $event->id; */
                $matchModel->match_number = $match['matchNumber'];
                /* $matchModel->description = $match['description']; */
                $matchModel->tournament_level = $match['tournamentLevel'];
                /* $matchModel->set_alliance_teams($match['alliances']['red']['teamKeys'], $match['alliances']['blue']['teamKeys']);
                $matchModel->set_alliance_score($match['alliances']['red']['score'], $match['alliances']['blue']['score']); */
                $matchModel->save();
                $match_ids[] = ['match_id' => $matchModel->id];

                if (!$event->matches()->where('match_id', $matchModel->id)->where('start_time', (new self)::iso_to_date_time($match['startTime']))->exists()) {
                    $_created_match = $event->matches()->create(["match_id" => $matchModel->id, "start_time" => (new self)::iso_to_date_time($match['startTime'])]);
                    foreach ($match['teams'] as $team) {
                        $_team = Team::where('number', $team['teamNumber'])->first();
                        if ($_team)
                            $_created_match->teams()->create(['team_id' => $_team->id, 'station' => $team['station']]);
                    }
                }

                /* $_created_match->teams()->createMany(); */
                /* $event->matches->constains($matchModel->id) ?: $event->matches()->attach($matchModel->id, ['season_id' => $season->id, 'start_time' => (new self)::iso_to_date_time($match['startTime'])]); */
            }
            /* $event->matches()->createMany($match_ids); */
        }
    }
    /*
        * Update or Create Teams Data. If is there any data, update it. If not, create it.
        * @param bool $includeImages: true if you want to update team images
    */

    static public function update_teams(?bool $includeImages = false): void
    {
        $season = Season::where('year', (new self)::$season)->get()->first();
        $events = $season->events;

        foreach ($events as $event) {
            $response = self::get_teams(['eventCode' => $event->event->code], true);
            if (!isset($response)) return;
            $teams = $response['teams'];
            $team_ids = [];
            foreach ($teams as $team) {
                $teamModel = Team::where('number', $team['teamNumber'])->first();
                if (!$teamModel)
                    $teamModel = new Team();
                $teamModel->number = $team['teamNumber'];
                $teamModel->name = $team['nameShort'];
                $teamModel->save();

                if (!$event->teams()->where('team_id', $teamModel->id)->exists())
                    $team_ids[] = ["team_id" => $teamModel->id];

                /* if (EventTeam::where('season_event_id', $current_season->id)->where('event_id', $eventModel->id)->get()->isEmpty())
                    SeasonEvent::create(['season_id' => $current_season->id, 'event_id' => $eventModel->id]); */
                /* $event->teams->contains($teamModel) ?: $event->teams()->attach($teamModel, ['season_id' => $season->id]); */
            }
            $event->teams()->createMany($team_ids);
        }
        if ($includeImages) (new self)::update_team_images();
    }

    /*
        * Update or Create Team Images
        * @param bool $deleteOlds: delete old images if exists
    */
    static public function update_team_images(?bool $deleteOlds = false): void
    {
        $teams = (new self)::get_images(null);
        foreach ($teams as $team) {
            if ($team['encodedAvatar'] == "" || $team['encodedAvatar'] == null) continue;
            $base_path      = 'media/teams/';
            $file_name      = $team['teamNumber'] . '.png';
            if (Storage::disk('public')->exists($base_path . $file_name)) {
                if ($deleteOlds != null && $deleteOlds == true)
                    Storage::disk('public')->delete($base_path . $file_name);
                else
                    continue;
            }
            $image = base64_decode($team['encodedAvatar']);
            $url = '/storage/' . $base_path  . $file_name;
            file_put_contents(public_path() . $url, $image);
        }
    }

    /*
        * Update Or Create Current Season Events
    */
    static public function update_events(): void
    {
        $response = self::get_events(null, true);
        if (!isset($response)) return;
        $current_season = Season::where('year', self::$season)->get()->first();
        $event_ids = [];
        foreach ($response['Events'] as $event) {
            $eventModel = Event::where('code', $event['code'])->first();
            if (!$eventModel)
                $eventModel = new Event();
            $eventModel->code = $event['code'];
            $eventModel->name = $event['name'];
            $eventModel->type = $event['type'];
            $eventModel->week_number = $event['weekNumber'];
            $eventModel->start_date = (new self)::iso_to_date_time($event['dateStart']);
            $eventModel->end_date = (new self)::iso_to_date_time($event['dateEnd']);
            $eventModel->save();
            /*     $event_ids[] = $eventModel->id; */
            if (SeasonEvent::where('season_id', $current_season->id)->where('event_id', $eventModel->id)->get()->isEmpty())
                SeasonEvent::create(['season_id' => $current_season->id, 'event_id' => $eventModel->id]);
        }
        /* $current_season->events()->syncWithoutDetaching($event_ids); */
    }

    /*
        * Update Or Create Current Season
    */
    static public function update_season_summary(): void
    {
        $response = self::get_season_summary(true);
        if (!isset($response)) return;
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

    static private function iso_to_date_time(string $iso): string
    {
        return date('Y-m-d h:i:s', strtotime($iso));
    }
}
