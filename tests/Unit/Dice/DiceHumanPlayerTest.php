<?php

declare(strict_types=1);

namespace App\Models\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the HumanPlayer class.
 */
class DiceHumanPlayerTest extends TestCase
{
    private HumanPlayer $player;

    protected function setUp(): void
    {
        $this->player = new HumanPlayer();
    }

    /**
     * Check constructor Player.
     */
    public function testCreatePlayerClass()
    {
        $this->assertInstanceOf("\\App\Models\Dice\HumanPlayer", $this->player);
    }

    public function testRemoveBitcoins()
    {
        $this->assertEquals(10, $this->player->getBalance());
        $this->assertEquals(8, $this->player->removeBitcoins(2));
        // try to remove more then half
        $this->assertEquals(8, $this->player->removeBitcoins(6));
    }
}
