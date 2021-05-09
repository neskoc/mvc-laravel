<?php

declare(strict_types=1);

namespace App\Models\Yatzy;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
final class YatzyYatzyGameTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    private YatzyGame $yatzyGame;

    protected function setUp(): void
    {
        $this->yatzyGame = new YatzyGame();
        $this->yatzyGame->diceHand->roll();
    }

    public function testCreateYatzyGameClass(): void
    {
        $this->assertInstanceOf("\\App\Models\Yatzy\YatzyGame", $this->yatzyGame);
    }
}
