<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            /* $table->foreignId('season_id')->references('id')->on('seasons')->onDelete('cascade'); */
            $table->text('name');
            $table->text('code');
            $table->integer('week_number');
            $table->text('type');
            $table->timestamps();
        });
    }

    /*  {
        "allianceCount": "EightAlliance",
        "weekNumber": 3,
        "announcements": [],
        "code": "VA320",
        "divisionCode": null,
        "name": "CHS District Greater Richmond Event #2 Day 2",
        "type": "DistrictEvent",
        "districtCode": "CHS",
        "venue": "Keystone Tractor Works",
        "city": "Colonial Heights",
        "stateprov": "VA",
        "country": "USA",
        "dateStart": "2022-03-20T00:00:00",
        "dateEnd": "2022-03-20T23:59:59",
        "address": "880 W Roslyn Rd",
        "website": "https://www.firstchesapeake.org/",
        "webcasts": [],
        "timezone": "Eastern Standard Time"
    }, */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
