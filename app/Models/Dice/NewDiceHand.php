<?php

declare(strict_types=1);

namespace App\Models\Dice;

/**
 * NewDiceHand class.
 */

class NewDiceHand
{
    private array $dices;
    private int $sum;
    private int $nrOfDices = 0;

    public function __construct($nrOfDices = 2)
    {
        for ($i = 0; $i < $nrOfDices; $i += 1) {
            $this->addDice(new GraphicalDice());
        }
    }

    public function addDice(DiceInterface $dice)
    {
        $this->nrOfDices += 1;
        $this->dices[] = $dice;
    }

    public function rollSelectively(array $keep = []): array
    {
        // $len = count($this->dices);
        $rolled = [];
        for ($i = 0; $i < $this->nrOfDices; $i += 1) {
            if (!in_array($i, $keep)) {
                $this->dices[$i]->roll();
                $rolled[] = $i;
            }
        }
        return $rolled;
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

    public function getLastHand(): array
    {
        $dicesAsArray = [];
        // $len = count($this->dices);
        foreach ($this->dices as $dice) {
            $dicesAsArray[] = $dice->getLastRoll();
        }
        return $dicesAsArray;
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
