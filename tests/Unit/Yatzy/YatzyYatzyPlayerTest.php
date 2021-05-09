<?php

declare(strict_types=1);

namespace App\Models\Yatzy;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
final class YatzyYatzyPlayerTest extends TestCase
{
    /**
     * Test YatzyPlayer class.
     */
    private YatzyPlayer $yatzyPlayer;

    protected function setUp(): void
    {
        $this->yatzyPlayer = new YatzyPlayer(0);
    }

    public function testCreateYatzyPlayerClass(): void
    {
        $this->assertInstanceOf("\\App\Models\Yatzy\YatzyPlayer", $this->yatzyPlayer);
    }
}
