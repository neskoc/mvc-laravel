<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Dice\Game;

/**
 * Controller for a Game21 route = controller class.
 */
class Game21Controller extends Controller
{
    public function __invoke(Request $request): View
    {
        $callable = new Game();
        $request->session()->put('game', serialize($callable));

        return $callable->newGame();
    }

    public function start(Request $request): View
    {
        $callable = new Game();
        $request->session()->put('game', serialize($callable));

        return $callable->newGame();
    }

    public function playGame(Request $request): View
    {
        $callable = unserialize($request->session()->get('game'));

        return $callable->playGame();
    }

    public function playRound(Request $request): View
    {
        $callable = unserialize($request->session()->get('game'));

        return $callable->playRound($request);
    }

    public function roll(Request $request): View
    {
        $callable = unserialize($request->session()->get('game'));

        return $callable->roll($request);
    }
}
