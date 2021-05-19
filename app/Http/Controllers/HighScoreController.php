<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\HighScore;

class HighScoreController extends Controller
{
    public function __invoke(): View
    {
        $callable = new HighScore();

        return $callable->getHighScoreList();
    }
}
