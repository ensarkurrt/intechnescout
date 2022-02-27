<?php

namespace App\Console\Commands;

use App\Http\Controllers\FRCApiController;
use Illuminate\Console\Command;

class APITest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        FRCApiController::update_season_summary();
        FRCApiController::update_events();
        FRCApiController::update_teams(true);
        FRCApiController::update_event_matches();
        /* FRCApiController::test(); */
        /* FRCApiController::update_team_images(); */
    }
}
