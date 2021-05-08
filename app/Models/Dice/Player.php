<?php

declare(strict_types=1);

namespace App\Models\Dice;

/**
 * Player class.
 */

class Player
{

    protected float $bitcoinBalance;
    protected NewDiceHand $diceHand;
    protected int $roundScore;
    protected int $wins = 0;

    public function __construct($bitcoins)
    {
        $this->bitcoinBalance = $bitcoins;
    }

    public function addBitcoins($bitcoins): float
    {
        $this->bitcoinBalance += $bitcoins;

        return $this->bitcoinBalance;
    }

    public function removeBitcoins($bitcoins): float
    {
        if ($bitcoins <= $this->bitcoinBalance / 2) {
            $this->bitcoinBalance -= $bitcoins;
        }

        return $this->bitcoinBalance;
    }

    public function startRound($nrOfDices): void
    {
        $this->roundScore = 0;
        $this->diceHand = new NewDiceHand($nrOfDices);
    }

    public function playHand(): int
    {
        $this->roundScore += $this->diceHand->roll();
        return $this->roundScore;
    }

    public function getBalance(): float
    {
        return $this->bitcoinBalance;
    }

    public function getLastHand(): array
    {
        return $this->diceHand->getLastHand();
    }

    public function getLastGraphicalHand(): array
    {
        return $this->diceHand->getLastGraphicalHand();
    }

    public function getWins(): int
    {
        return $this->wins;
    }

    public function getRoundScore(): int
    {
        return $this->roundScore;
    }

    public function increaseWins(): int
    {
        $this->wins += 1;
        return $this->wins;
    }

    // extended for unit-testing

    public function getDiceHand(): NewDiceHand
    {
        return $this->diceHand;
    }
}
