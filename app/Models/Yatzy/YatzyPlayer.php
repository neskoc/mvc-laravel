<?php

declare(strict_types=1);

namespace App\Models\Yatzy;

/**
 * YatzyPlayer class.
 */

class YatzyPlayer
{
    public int $playerNr;
    public string $name;

    public function __construct(int $playerNr, string $name)
    {
        $this->playerNr = $playerNr;
        $this->name = $name;
    }
}
