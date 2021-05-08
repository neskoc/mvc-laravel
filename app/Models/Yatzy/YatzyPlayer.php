<?php

declare(strict_types=1);

namespace App\Models\Yatzy;

/**
 * YatzyPlayer class.
 */

class YatzyPlayer
{
    public int $playerNr;

    public function __construct(int $playerNr)
    {
        $this->playerNr = $playerNr;
    }
}
