<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_event_id')->references('id')->on('season_events')->onDelete('cascade');
            $table->foreignId('match_id')->references('id')->on('matches')->onDelete('cascade');
            $table->timestamp('start_time');
            /* $table->foreignId('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreignId('match_id')->references('id')->on('matches')->onDelete('cascade');
            $table->foreignId('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->timestamp('start_time'); */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('season_event_matches');
    }
}
