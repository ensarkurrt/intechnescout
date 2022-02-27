<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonEventTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_event_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_event_id')->references('id')->on('season_events')->onDelete('cascade');
            $table->foreignId('team_id')->references('id')->on('teams')->onDelete('cascade');
            /* $table->foreignId('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->foreignId('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreignId('event_id')->references('id')->on('events')->onDelete('cascade'); */
            /* $table->primary(['season_id', 'team_id', 'event_id']); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('season_event_teams');
    }
}
