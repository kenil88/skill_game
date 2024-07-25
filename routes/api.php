<?php

use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ScoreController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('scores', [ScoreController::class, 'store']);
    Route::get('leaderboard/daily/{gameId}', [LeaderboardController::class, 'getDailyRank']);
    Route::get('leaderboard/weekly/{gameId}', [LeaderboardController::class, 'getWeeklyRank']);
    Route::post('games', [GameController::class, 'store']); // Add game route
});
