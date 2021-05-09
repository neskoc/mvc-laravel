<?php

declare(strict_types=1);

namespace App\Models\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
final class DiceNewDiceHandTest extends TestCase
{
    private $diceHand;
    private $nrOfDices = 5;
    private $dices;

    protected function setUp(): void
    {
        $this->diceHand = new NewDiceHand($this->nrOfDices);
        $this->diceHand->roll();
        $this->dices = $this->diceHand->getDices();
    }

    /**
     * Check DiceHand and Dice classes.
    */
    public function testDiceHandClassInstance(): void
    {
        $this->assertInstanceOf("\\App\Models\Dice\NewDiceHand", $this->diceHand);
        $dices = $this->diceHand->getDices();
        foreach ($dices as $dice) {
            $this->assertInstanceOf("\\App\Models\Dice\GraphicalDice", $dice);
        }
    }

    public function testRollSumAndAverage(): void
    {
        $dices = $this->diceHand->getDices();
        $sum = $this->diceHand->roll();
        $testSum = 0;
        foreach ($dices as $dice) {
            $testSum += $dice->getLastRoll();
        }
        $average = $testSum / (float) $this->nrOfDices;
        $this->assertEquals($testSum, $sum);
        $this->assertEquals($testSum, $this->diceHand->getSum());
        $this->assertEquals($average, $this->diceHand->getAverage());
    }

    public function testRollSelectively(): void
    {
        $dices = $this->diceHand->getDices();
        $this->diceHand->roll();
        $prevHand = $this->diceHand->getLastHand();
        $keep = [1, 3, 4];
        $this->diceHand->rollSelectively($keep);
        $lastHand = $this->diceHand->getLastHand();
        foreach ($keep as $key) {
            $this->assertEquals($dices[$key]->getLastRoll(), $lastHand[$key]);
        }
        $this->assertNotEquals($prevHand, $lastHand);
    }

    public function testGetLastGraphicalHand(): void
    {
        $res = $this->diceHand->getLastGraphicalHand();
        $testRes = [];
        for ($i = 0; $i < $this->nrOfDices; $i += 1) {
            $testRes[$i] = $this->dices[$i]->graphic();
        }
        $this->assertEquals($testRes, $res);
    }
}
