<?php

declare(strict_types=1);

namespace App\Models\Dice;

/**
 * HumanPlayer class.
 */

class HumanPlayer extends Player
{

    public function __construct($bitcoins = 10)
    {
        parent::__construct($bitcoins);
    }

    public function removeBitcoins($bitcoins): float
    {
        if ($bitcoins <= $this->bitcoinBalance / 2) {
            $this->bitcoinBalance -= $bitcoins;
        }

        return $this->bitcoinBalance;
    }
}
