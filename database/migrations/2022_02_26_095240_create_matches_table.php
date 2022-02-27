<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            /* $table->foreignId('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->foreignId('event_id')->references('id')->on('events')->onDelete('cascade'); */
            /* $table->text('description'); */
            $table->text('tournament_level');
            /* $table->timestamp('start_time'); */
            $table->integer('match_number');
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
        Schema::dropIfExists('matches');
    }
}
