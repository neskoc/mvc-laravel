<?php

declare(strict_types=1);

namespace App\Models\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
class DiceDiceTest extends TestCase
{
    /**
     * Try to create the Dice class.
     */
    public function testCreateDiceClass()
    {
        // default nr of faces = 6
        $nrOfFaces = 6;
        $dice = new Dice();
        $this->assertInstanceOf("\\App\Models\Dice\Dice", $dice);

        $roll = $dice->roll();
        $this->assertLessThanOrEqual($nrOfFaces, $roll);
        $this->assertGreaterThanOrEqual(1, $roll);
        $this->assertEquals($dice->getLastRoll(), $roll);


        $nrOfFaces = 10;
        $dice = new Dice(10);
        $this->assertInstanceOf("\\App\Models\Dice\Dice", $dice);

        $roll = $dice->roll();
        $this->assertLessThanOrEqual($nrOfFaces, $roll);
        $this->assertGreaterThanOrEqual(1, $roll);
        $this->assertEquals($dice->getLastRoll(), $roll);
    }
}
