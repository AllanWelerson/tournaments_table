<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/register', [UserController::class,'index']);
// Route::post('/register', [UserController::class,'store']);

Route::middleware(['auth:sanctum','verified'])->group(function(){
    Route::get('/', function () { return response()->redirectToRoute('tournament.index');});
    Route::get('/team', [TeamController::class, 'index'])->name('team.index');
    Route::post('/team', [TeamController::class, 'store'])->name('team.store');
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournament.index');
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournament.store');
    Route::get('/tournaments/{id}', [TournamentController::class, 'show'])->name('tournament.show');
    Route::get('/teams', [\App\Http\Controllers\Api\TeamController::class, 'index'])->name('teams.index.ajax');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia\Inertia::render('Dashboard');
// })->name('dashboard');
