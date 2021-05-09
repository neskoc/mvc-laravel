<?php

namespace App\Routes;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Game21Controller;
use App\Http\Controllers\YatzyController;

Route::get("/", [Game21Controller::class, 'start'])->name('game21');
Route::prefix("/game21")->group(function () {
    Route::get("", [Game21Controller::class, 'start']);
    if (isset($_POST['resetGame'])) {
        Route::post("", [Game21Controller::class, 'start']);
    } elseif (isset($_POST['playGame'])) {
        Route::post("", [Game21Controller::class, "playGame"]);
    } elseif (isset($_POST['playHand'])) {
        Route::post("", [Game21Controller::class, "playRound"]);
    } elseif (isset($_POST['roll']) || isset($_POST['stop'])) {
        Route::post("", [Game21Controller::class, "roll"]);
    }
});

Route::prefix("/yatzy")->group(function () {
    Route::get("", [YatzyController::class, "initialize"])->name('yatzy');
    Route::get("/play", [YatzyController::class, "playHand"]);
    Route::post("/play", [YatzyController::class, "playHand"])->name("play-yatzy");
    Route::get("/save", [YatzyController::class, "saveHand"])->name("saveYatzy");
    Route::post("/save", [YatzyController::class, "saveHand"]);
    Route::get("/game-over", [YatzyController::class, "gameOver"])->name('game-over');
});
