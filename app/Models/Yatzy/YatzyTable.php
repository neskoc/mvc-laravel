<?php

declare(strict_types=1);

namespace App\Models\Yatzy;

/**
 * YatzyTable class.
 */

class YatzyTable implements ShowYatzyTableInterface
{
    use ShowYatzyTable;

    private array $lastHand;

    public const ROWS = 14; // extended yatzy
    public const ROW_NAMES = [
        "Ettor",
        "Tvåor",
        "Treor",
        "Fyror",
        "Femmor",
        "Sexor",
        "Par",
        "Två par",
        "Triss",
        "Fyrtal",
        "Kåk",
        "Liten stege",
        "Stor stege",
        "Chans"
    ];
    public array $yatzyColumns; // array of YatzyColumn(s)
    public YatzyColumn $currentColumn;
    public int $nrYazyColumns = 0; // one for each Player

    public function __construct(int $nrOfPlayers)
    {
        for ($i = 0; $i < $nrOfPlayers; $i += 1) {
            $this->addYatzyColumn(new YatzyColumn());
        }
        $this->currentColumn = $this->yatzyColumns[0];
    }

    public function addYatzyColumn(YatzyColumnInterface $yatzyColumn)
    {
        $this->nrYazyColumns += 1;
        $this->yatzyColumns[] = $yatzyColumn;
    }

    public function getAvailableSlots(): array
    {
        return $this->currentColumn->getAvailableSlots($this->lastHand);
    }

    public function disableSlot(int $rowNr): void
    {
        $this->currentColumn->disableSlot($rowNr);
    }

    public function isSlotEnabled(int $rowNr): bool
    {
        return $this->currentColumn->isSlotEnabled($rowNr);
    }

    public function isSlotAllowed(int $value): bool
    {
        return $this->currentColumn->isSlotAllowed($value, $this->lastHand);
    }

    public function isChanceAvailableAndEnabled(): bool
    {
        return $this->currentColumn->isChanceAvailableAndEnabled();
    }

    public function isSlotAvailableAllowedAndEnabled(int $index): bool
    {
        $slotAAE = false;
        $availableSlots = $this->getAvailableSlots();
        // var_dump($availableSlots);
        // var_dump($this->currentColumn->occupiedSlots);
        if (
            in_array($index, $availableSlots) &&
            $this->isSlotEnabled($index)
        ) {
            $slotAAE = true;
        }
        return $slotAAE;
    }

    public function isAnySlotAvailableAllowedAndEnabled(): bool
    {
        return $this->currentColumn->isAnySlotAvailableAllowedAndEnabled($this->lastHand);
    }

    public function saveValue(int $value): void
    {
        $this->currentColumn->saveValue($value, $this->lastHand);
    }

    public function getLastHand(): array
    {
        return $this->lastHand;
    }

    public function setLastHand(array $hand): void
    {
        $this->lastHand = $hand;
    }
}
