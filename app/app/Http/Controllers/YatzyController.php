<?php

declare(strict_types=1);

namespace neskoc\Controller;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use neskoc\Yatzy\YatzyGame;

/**
 * Controller for a Yatzy route = controller class.
 */
class YatzyController extends Controller
{
    public function __invoke(): View
    {
        return $this->initialize();
    }

    public function initialize(): View
    {
        $callable = new YatzyGame();
        $_SESSION['yatzy-game'] = serialize($callable);

        $body = $callable->initialize();

        return $this->gamePsr17Factory($body);
    }

    public function playHand(): View
    {
        $callable = unserialize($_SESSION['yatzy-game']);
        $body = $callable->playHand();
        $_SESSION['yatzy-game'] = serialize($callable);

        return $this->gamePsr17Factory($body);
    }

    public function saveHand(): View
    {
        $callable = unserialize($_SESSION['yatzy-game']);
        $body = $callable->saveHand();
        $_SESSION['yatzy-game'] = serialize($callable);

        return $this->gamePsr17Factory($body);
    }

    public function gameOver(): View
    {
        $callable = unserialize($_SESSION['yatzy-game']);
        $body = $callable->gameOver();

        return $this->gamePsr17Factory($body);
    }
}
