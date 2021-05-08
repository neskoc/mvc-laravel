<?php

declare(strict_types=1);

namespace App\Models\Dice;

/**
 * Dice class.
 */

class GraphicalDice extends Dice implements DiceInterface
{
    /**
     * @const int SIDES Number of dice sides
     */
    private array $graphic = [
        1 => "⚀",
        2 => "⚁",
        3 => "⚂",
        4 => "⚃",
        5 => "⚄",
        6 => "⚅"
    ];

    public function __construct()
    {
        parent::__construct(self::SIDES);
    }

    public function graphic(): string
    {
        return $this->graphic[parent::getLastRoll()];
    }
}
