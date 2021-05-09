<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Yatzy\YatzyGame;

/**
 * Controller for a Yatzy route = controller class.
 */
class YatzyController extends Controller
{
    public function __invoke(Request $request): View
    {
        return $this->initialize($request);
    }

    public function initialize(Request $request): View
    {
        $callable = new YatzyGame();
        $request->session()->put('yatzy-game', serialize($callable));

        return $callable->initialize();
    }

    public function playHand(Request $request)
    {
        $callable = unserialize($request->session()->get('yatzy-game'));
        return $callable->playHand($request);
    }

    public function saveHand(Request $request)
    {
        $callable = unserialize($request->session()->get('yatzy-game'));
        return $callable->saveHand($request);
    }

    public function gameOver(Request $request): View
    {
        $callable = unserialize($request->session()->get('yatzy-game'));
        return $callable->gameOver();
    }
}
