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
            $table->bigInteger('round_id')->unsigned();
            $table->foreign('round_id')->references('id')->on('rounds');
            $table->bigInteger('team_1_id')->unsigned();
            $table->foreign('team_1_id')->references('id')->on('teams');
            $table->bigInteger('team_2_id')->unsigned();
            $table->foreign('team_2_id')->references('id')->on('teams');
            $table->dateTime('date')->nullable()->default(null);
            $table->integer('goals_team_1')->nullable()->default(null);
            $table->integer('goals_team_2')->nullable()->default(null);
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
