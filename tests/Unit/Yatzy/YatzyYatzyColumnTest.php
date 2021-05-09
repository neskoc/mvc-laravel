<?php

declare(strict_types=1);

namespace App\Models\Yatzy;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
final class YatzyYatzyColumnTest extends TestCase
{
    /**
     * Test YatzyColumn class.
     */
    private YatzyColumn $yatzyColumn;

    protected function setUp(): void
    {
        $this->yatzyColumn = new YatzyColumn();
    }

    public function testCreateYatzyColumnClass(): void
    {
        $this->assertInstanceOf("\\App\Models\Yatzy\YatzyColumn", $this->yatzyColumn);
    }

    public function testGetAvailableSlots(): void
    {
        $hand = [1, 2, 3, 4, 5];
        $availableSlots = [0, 1, 2, 3, 4, 11];

        $this->assertEquals($availableSlots, $this->yatzyColumn->getAvailableSlots($hand));
    }

    public function testIsSlotAllowed(): void
    {
        $hand = [1, 2, 3, 4, 5];
        $this->assertTrue($this->yatzyColumn->isSlotAllowed(0, $hand));
        $hand = [1, 1, 3, 4, 5];
        $this->assertTrue($this->yatzyColumn->isSlotAllowed(6, $hand));
        $hand = [1, 1, 3, 3, 5];
        $this->assertTrue($this->yatzyColumn->isSlotAllowed(7, $hand));
        $hand = [1, 1, 1, 3, 3];
        $this->assertTrue($this->yatzyColumn->isSlotAllowed(8, $hand));
        $hand = [1, 1, 1, 1, 5];
        $this->assertTrue($this->yatzyColumn->isSlotAllowed(9, $hand));
        $hand = [1, 1, 3, 3, 3];
        $this->assertTrue($this->yatzyColumn->isSlotAllowed(10, $hand));
    }

    public function testsSaveValue(): void
    {
        $hand = [1, 2, 3, 4, 5];
        for ($ix = 0; $ix < 5; $ix += 1) {
            $score = $ix + 1;
            $this->yatzyColumn->saveValue($ix, $hand);
            $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);
        }

        $ix = 5;
        $hand = [6, 6, 6, 6, 6];
        $score = 30;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);

        $ix = 6;
        $hand = [2, 2, 3, 4, 5];
        $score = 4;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);

        $ix = 7;
        $hand = [2, 2, 4, 4, 5];
        $score = 12;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);
        $ix = 8;
        $hand = [2, 2, 2, 4, 5];
        $score = 6;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);

        $ix = 9;
        $hand = [2, 2, 2, 2, 5];
        $score = 8;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);

        $ix = 10;
        $hand = [2, 2, 2, 5, 5];
        $score = 16;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);

        $ix = 11;
        $hand = [1, 2, 3, 4, 5];
        $score = 15;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);

        $ix = 12;
        $hand = [2, 3, 4, 5, 6];
        $score = 20;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);

        $ix = 13;
        $hand = [2, 3, 4, 5, 6];
        $score = 20;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);

        $this->yatzyColumn->strike = true;
        $ix = 0;
        $hand = [1, 2, 3, 4, 5];
        $score = 0;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);

        $this->yatzyColumn = new YatzyColumn();
        $ix = 7;
        $hand = [2, 2, 4, 4, 4];
        $score = 12;
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals($score, $this->yatzyColumn->yatzyColumn[$ix], (string) $ix);
    }

    public function testCalculateSumAndTotal(): void
    {
        $hands = [
            [1, 1, 1, 1, 1], //  5
            [2, 2, 2, 2, 2], // 10
            [3, 3, 3, 3, 3], // 15
            [4, 4, 4, 4, 4], // 20
            [5, 5, 5, 5, 5], // 25
            [6, 6, 6, 6, 6]  // 30
        ];
        for ($ix = 0; $ix < 6; $ix += 1) {
            $this->yatzyColumn->saveValue($ix, $hands[$ix]);
        }

        $ix = 12;
        $hand = [2, 3, 4, 5, 6];
        $this->yatzyColumn->saveValue($ix, $hand);
        $ix = 13;
        $hand = [6, 6, 6, 6, 6];
        $this->yatzyColumn->saveValue($ix, $hand);
        $this->assertEquals(105, $this->yatzyColumn->sum);
    }

    public function testIsSlotEnabled(): void
    {
        $ix = 11;
        $this->yatzyColumn->disableSlot($ix);

        $this->assertFalse($this->yatzyColumn->isSlotEnabled($ix));
    }

    public function testIsAnySlotAvailableAllowedAndEnabled(): void
    {
        $hand = [1, 2, 3, 4, 5];

        $this->assertTrue($this->yatzyColumn->isAnySlotAvailableAllowedAndEnabled($hand));
    }

    public function testIsChanceAvailableAndEnabled(): void
    {
        $this->assertTrue($this->yatzyColumn->isChanceAvailableAndEnabled());
    }
}
