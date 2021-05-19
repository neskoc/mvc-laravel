<?php

declare(strict_types=1);

namespace App\Models\Yatzy;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
final class YatzyYatzyTableTest extends TestCase
{
    /**
     * Test YatzyTable class.
     */
    private YatzyTable $yatzyTable;

    protected function setUp(): void
    {
        $this->yatzyTable = new YatzyTable(1);
    }

    public function testCreateYatzyPlayerClass(): void
    {
        $this->assertInstanceOf("\\App\Models\Yatzy\YatzyTable", $this->yatzyTable);
    }

    public function testSlotEnabled(): void
    {
        $rowNr = 11;
        $this->yatzyTable->disableSlot($rowNr);

        $this->assertFalse($this->yatzyTable->isSlotEnabled($rowNr));
    }

    public function testIsChanceAvailableAndEnabled(): void
    {
        $this->assertTrue($this->yatzyTable->isChanceAvailableAndEnabled());
    }

    public function testIsSlotAvailableAllowedAndEnabled(): void
    {
        $lastHand = [1, 2, 3, 4, 5];
        $this->yatzyTable->setLastHand($lastHand);
        $this->assertEquals($lastHand, $this->yatzyTable->getLastHand());

        $rowNr = 1;
        $this->assertTrue($this->yatzyTable->isSlotAvailableAllowedAndEnabled($rowNr));

        $this->yatzyTable->saveValue($rowNr);
        $this->assertTrue($this->yatzyTable->isSlotAllowed($rowNr), 'isSlotAllowed');

        $this->assertFalse($this->yatzyTable->isSlotAvailableAllowedAndEnabled($rowNr));

        $this->assertTrue($this->yatzyTable->isAnySlotAvailableAllowedAndEnabled());
    }

    public function testShowYatzyTable(): void
    {
        $yatzyGame = new YatzyGame();
        $yatzyGame->yatzyPlayers[1] = new YatzyPlayer(1, 'Name for test');
        $yatzyGame->currentPlayer = $yatzyGame->yatzyPlayers[1];
        $lastHand = [1, 2, 3, 4, 5];
        $this->yatzyTable->setLastHand($lastHand);
        $thead = '<thead><tr><th></th><th class="center">Name for test</th></tr></thead>';
        $this->assertStringContainsString(
            $thead,
            $this->yatzyTable->showYatzyTable($this->yatzyTable, $yatzyGame, false)
        );

        $thead = '<thead><tr><th></th><th class="center">Name for test</th><th class="center">Val</th></tr></thead>';
        $this->assertStringContainsString(
            $thead,
            $this->yatzyTable->showYatzyTable($this->yatzyTable, $yatzyGame, true)
        );

        for ($i = 0; $i < $this->yatzyTable::ROWS; $i += 1) {
            $this->yatzyTable->currentColumn->occupiedSlots[$i] = true;
        }
        $thead = '<thead><tr><th></th><th class="center">Name for test</th><th class="center">Val</th></tr></thead>';
        $this->assertStringContainsString(
            $thead,
            $this->yatzyTable->showYatzyTable($this->yatzyTable, $yatzyGame, true)
        );

        $this->yatzyTable->currentColumn->occupiedSlots[$this->yatzyTable::ROWS - 1] = false;
        $thead = '<thead><tr><th></th><th class="center">Name for test</th><th class="center">Val</th></tr></thead>';
        $this->assertStringContainsString(
            $thead,
            $this->yatzyTable->showYatzyTable($this->yatzyTable, $yatzyGame, true)
        );
    }
}
