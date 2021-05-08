<?php

declare(strict_types=1);

namespace App\Models\Dice;

/**
 * Dice class.
 */

class Dice implements DiceInterface
{
    private int $faces;

    private ?int $rollResult = null;

    public function __construct($faces = 6)
    {
        $this->faces = $faces;
    }

    public function roll(): int
    {
        $this->rollResult = rand(1, $this->faces);

        return $this->rollResult;
    }

    public function getLastRoll(): ?int
    {
        return $this->rollResult;
    }
}
