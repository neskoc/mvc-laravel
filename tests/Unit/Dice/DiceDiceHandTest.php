<?php

declare(strict_types=1);

namespace App\Models\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
final class DiceDiceHandTest extends TestCase
{
    private $diceHand;
    private $nrOfDices = 2;
    private $dices;

    protected function setUp(): void
    {
        $this->diceHand = new DiceHand($this->nrOfDices);
        $this->diceHand->roll();
        $this->dices = $this->diceHand->getDices();
    }

    /**
     * Check DiceHand and Dice classes.
    */
    public function testDiceHandClassInstance(): void
    {
        $this->assertInstanceOf("\\App\Models\Dice\DiceHand", $this->diceHand);
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

    public function testGetLastRoll(): void
    {
        $res = $this->diceHand->getLastHand();
        $testRes = "";
        for ($i = 0; $i < $this->nrOfDices; $i += 1) {
            $separator = ", ";
            if ($i === $this->nrOfDices - 1) {
                $separator = "";
            }
            $testRes .= $this->dices[$i]->getLastRoll() . $separator;
        }
        $this->assertEquals($testRes, $res);
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
