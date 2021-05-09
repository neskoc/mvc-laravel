<?php

declare(strict_types=1);

namespace App\Models\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
class DicePlayerTest extends TestCase
{
    /**
     * Test Player class.
     */
    public function testPlayerClass()
    {
        $bitcoins = 10;
        $player = new Player($bitcoins);
        $this->assertInstanceOf("\\App\Models\Dice\Player", $player);
        $this->assertEquals($bitcoins, $player->getBalance());

        $bitcoins += 2;
        $player->addBitcoins(2);
        $this->assertEquals($bitcoins, $player->getBalance());

        $bitcoins -= 4;
        $player->removeBitcoins(4);
        $this->assertEquals($bitcoins, $player->getBalance());

        $wins = 0;
        $this->assertEquals($wins, $player->getWins());
        $wins += 1;
        $player->increaseWins();
        $this->assertEquals($wins, $player->getWins());

        $nrOfDices = 2;
        $roundScore = 0;
        $player->startRound($nrOfDices);
        $this->assertEquals($roundScore, $player->getRoundScore());

        $diceHand = $player->getDiceHand();
        $this->assertInstanceOf("\\App\Models\Dice\NewDiceHand", $diceHand);
        $roundScore = $player->playHand();
        $this->assertEquals($diceHand->getSum(), $roundScore);
        $this->assertEquals($diceHand->getLastHand(), $player->getLastHand());
        $this->assertEquals($diceHand->getLastGraphicalHand(), $player->getLastGraphicalHand());
    }
}
