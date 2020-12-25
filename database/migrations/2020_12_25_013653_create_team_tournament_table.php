<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_tournament', function (Blueprint $table) {
            $table->primary(['team_id','tournament_id']);
            $table->bigInteger('team_id')->unsigned();
            $table->bigInteger('tournament_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('tournament_id')->references('id')->on('tournaments');
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
        Schema::dropIfExists('team_tournament');
    }
}
