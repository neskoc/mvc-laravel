<?php

declare(strict_types=1);

namespace App\Models\Dice;

/**
 * Dice class.
 */

class DiceHand
{
    private array $dices;
    private int $sum;
    private int $nrOfDices;

    public function __construct($nrOfDices = 2)
    {
        $this->nrOfDices = $nrOfDices;
        for ($i = 0; $i < $nrOfDices; $i += 1) {
            $this->dices[$i] = new GraphicalDice();
        }
    }

    public function roll(): int
    {

        $this->sum = 0;
        // $len = count($this->dices);
        for ($i = 0; $i < $this->nrOfDices; $i += 1) {
            $this->sum += $this->dices[$i]->roll();
        }
        return $this->sum;
    }

    public function getLastHand(): string
    {
        $res = "";
        // $len = count($this->dices);
        for ($i = 0; $i < $this->nrOfDices; $i += 1) {
            $separator = ", ";
            if ($i === $this->nrOfDices - 1) {
                $separator = "";
            }
            $res .= $this->dices[$i]->getLastRoll() . $separator;
        }
        return $res;
    }

    public function getLastGraphicalHand(): array
    {
        $res = [];
        for ($i = 0; $i < $this->nrOfDices; $i += 1) {
            $res[$i] = $this->dices[$i]->graphic();
        }
        return $res;
    }

    public function getSum(): int
    {
        return $this->sum;
    }

    public function getAverage(): float
    {
        return $this->sum / (float) $this->nrOfDices;
    }

    // extended for unit-testing

    public function getDices(): array
    {
        return $this->dices;
    }
}
