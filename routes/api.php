<?php

use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TournamentClubs;
use App\Http\Controllers\Api\TournamentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/teams', [TeamController::class, 'index']);
Route::post('/tournamentClubs/{tournamentId}', [TournamentClubs::class, 'store']);
Route::delete('/tournamentClubs/{tournamentId}/{clubId}', [TournamentClubs::class, 'destroy']);
Route::get('/tournaments/{id}', [TournamentController::class, 'show']);
