<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Round;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($tournamentId, Request $request)
    {
        $tournament = Tournament::where('id', $tournamentId)->first();
        $teams = $tournament->teams->toArray();

        $totalTeams = count($teams);
        $halfTeams = $totalTeams / 2;
        $teamMove = null;

        for($i = 0; $i < $totalTeams - 1; $i++){
            $round = new Round();
            $round->numero = $i + 1;
            $round->tournament_id = $tournamentId;
            $round = Round::create($round->toArray());

            for($j = 0; $j < $halfTeams; $j ++){
                if($j % 2 == 1 || $i % 2 == 1 && $j == 0){
                    $team1 = $teams[$j];
                    $team2 = $teams[$halfTeams + $j];
                    $game = new Match();
                    $game->team_1_id = $team1['id'];
                    $game->team_2_id = $team2['id'];
                    $game->round_id = $round->id;

                    $match = Match::create($game->toArray());
                }else{
                    $team1 = $teams[$halfTeams + $j];
                    $team2 = $teams[$j];
                    $game = new Match();
                    $game->team_1_id = $team1['id'];
                    $game->team_2_id = $team2['id'];
                    $game->round_id = $round->id;

                    $match = Match::create($game->toArray());
                }
            }

            $teamMove = $teams[$halfTeams];
            array_splice($teams, $halfTeams, 1);
            array_splice($teams, 1, 0, [$teamMove]);
            $teamMove = $teams[$halfTeams];
            array_splice($teams, $halfTeams, 1);
            $teams[] = $teamMove;
        }

        return Inertia::render('Tournaments/Info');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
