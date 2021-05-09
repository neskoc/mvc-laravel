<?php

declare(strict_types=1);

namespace App\Models\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
class DiceComputerPlayerTest extends TestCase
{
    private ComputerPlayer $player;

    protected function setUp(): void
    {
        $this->player = new ComputerPlayer();
    }

    /**
     * Check constructor Player.
     */
    public function testCreatePlayerClass()
    {
        $this->assertInstanceOf("\\App\Models\Dice\ComputerPlayer", $this->player);
    }

    public function testRemoveBitcoins()
    {
        $this->assertEquals(100, $this->player->getBalance());
        $this->assertEquals(90, $this->player->removeBitcoins(10));
        // try to remove more then half
        $this->assertEquals(30, $this->player->removeBitcoins(60));
    }
}
