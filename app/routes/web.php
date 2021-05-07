<?php

namespace neskoc\Router;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\Game21Controller;
use App\Http\Controllers\YatzyController;

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
    Route::post("/play", [YatzyController::class, "playHand"]);
    Route::get("/save", [YatzyController::class, "saveHand"]);
    Route::post("/save", [YatzyController::class, "saveHand"]);
    Route::get("/game-over", [YatzyController::class, "gameOver"]);
});

// Added for mos example code
Route::get('/hello-world', function () {
    echo "Hello World";
});
Route::get('/hello-world-view', function () {
    return view('message', [
        'message' => "Hello World from within a view"
    ]);
});
Route::get('/hello', [HelloWorldController::class, 'hello']);
Route::get('/hello/{message}', [HelloWorldController::class, 'hello']);

// Route::get('/', function () {
//     return view('welcome');
// });
