<?php

declare(strict_types=1);

namespace App\Models\Yatzy;

/**
 * YatzyColumn class.
 */

class YatzyColumn implements YatzyColumnInterface
{
    public array $yatzyColumn = []; // objects
    public array $occupiedSlots; // booleans
    public array $disabledSlots; // booleans
    public int $sum = 0;
    public int $total = 0;
    public int $bonus = 0;
    public int $yatzy = 0;
    public bool $strike = false;
    public bool $active = true;

    public function __construct()
    {
        for ($i = 0; $i < self::ROWS; $i += 1) {
            $this->occupiedSlots[$i] = false;
            $this->disabledSlots[$i] = false;
        }
    }

    public function getAvailableSlots(array $hand): array
    {
        sort($hand);
        $availableSlots = [];
        foreach ($this->occupiedSlots as $key => $value) {
            if (!$value && $this->isSlotAllowed($key, $hand)) {
                array_push($availableSlots, $key);
            }
        }
        return $availableSlots;
    }

    public function disableSlot(int $rowNr): void
    {
        $this->disabledSlots[$rowNr] = true;
        $this->yatzyColumn[$rowNr] = 0;
    }

    public function isSlotAllowed(int $index, array $hand): bool
    {
        $available = false;
        $unique = array_unique($hand);
        $len = count($unique);
        sort($hand);
        $value = $index + 1;
        $arrayCountValues = array_count_values($hand);
        if ($value < 7) {
            $available = $this->checkFirst6($value, $hand);
        } else {
            switch ($value) {
                case 7: // pair
                    $nrPairs = $this->nrOfPairs($arrayCountValues);
                    if ($nrPairs === 1 || $nrPairs) {
                        $available = true;
                    };
                    break;
                case 8: // two pairs
                    if ($this->countXOfAKind($arrayCountValues, 2) === 2) {
                        $available = true;
                    }
                    break;
                case 9: // thre of a kind
                    if ($this->countXOfAKind($arrayCountValues, 3) === 1) {
                        $available = true;
                    }
                    break;
                case 10: // four of a kind
                    // var_dump(reset($unique));
                    // exit();
                    if ($this->countXOfAKind($arrayCountValues, 4) === 1) {
                        $available = true;
                    }
                    break;
                case 11: // full house
                    $nrOfAKind = $this->nrOfAKind($arrayCountValues, reset($unique));
                    if ($len === 2 && ($nrOfAKind === 2 || $nrOfAKind === 3)) {
                        $available = true;
                    };
                    break;
                case 12: // small straight
                    $smallStraight = [1, 2, 3, 4, 5];
                    $available = ($smallStraight === $hand);
                    break;
                case 13: // large straight
                    $largeStraight = [2, 3, 4, 5, 6];
                    $available = ($largeStraight === $hand);
                    break;
                case 14: // chance
                    $available = false;
                    break;
            }
        }
        return $available;
    }

    public function saveValue(int $index, array $hand): void
    {
        if ($this->strike) {
            $this->total -= $this->yatzyColumn[$index];
            if ($index < 6) {
                $this->sum -= $this->yatzyColumn[$index];
            }
            $this->yatzyColumn[$index] = 0;
            $this->disabledSlots[$index] = true;
            $this->occupiedSlots[$index] = true;
            $this->strike = false;
            if (!in_array(false, $this->occupiedSlots)) {
                $this->active = false;
            }
        } else {
            $score = 0;
            $unique = array_unique($hand);
            $len = count($unique);
            rsort($hand);
            $value = $index + 1;
            $arrayCountValues = array_count_values($hand);
            if ($value < 7) {
                $score = $value * $this->nrOfAKind($arrayCountValues, $value);
            } else {
                switch ($value) {
                    case 7: // pair
                        $score = 2 * $this->getAllPairValues($arrayCountValues)[0];
                        break;
                    case 8: // two pairs
                        $score = $this->calculateTwoPairs($arrayCountValues);
                        break;
                    case 9: // three of a kind
                        $score = 3 * $this->valueOfXOfAKind($arrayCountValues, 3);
                        break;
                    case 10: // four of a kind
                        $score = 4 * $this->valueOfXOfAKind($arrayCountValues, 4);
                        break;
                    case 11: // full house
                        $score = array_sum($hand);
                        break;
                    case 12: // small straight
                        $score = 15;
                        break;
                    case 13: // big straight
                        $score = 20;
                        break;
                    case 14: // chance
                        $score = array_sum($hand);
                        break;
                }
            }
            $this->yatzyColumn[$index] = $score;
            $this->occupiedSlots[$index] = true;
            $this->calculateSumAndTotal($score, $value);
            // var_dump($this->occupiedSlots);
            // exit();
            if (!in_array(false, $this->occupiedSlots)) {
                $this->active = false;
                $yatzyArray = [5, 10, 15, 20, 25, 30];
                for ($ix = 0; $ix < 6; $ix += 1) {
                    if ($this->yatzyColumn[$ix] === $yatzyArray[$ix]) {
                        $this->yatzy = 50;
                        $this->total += 50;
                        break;
                    }
                }
            }
        }
    }

    private function calculateSumAndTotal(int $score, $index): void
    {
        if ($index < 7) {
            $this->sum += $score;
        }
        $this->total += $score;
        if ($this->sum >= 63) {
            $this->bonus = 50;
            $this->total += 50;
        }
    }

    private function checkFirst6(int $value, array $hand): bool
    {
        // var_dump($value . json_encode($hand));
        if (in_array($value, $hand)) {
            return true;
        }
        return false;
    }

    private function getAllPairValues(array $arrayCountValues): array
    {
        $pairValues = [];
        foreach ($arrayCountValues as $key => $value) {
            if ($value === 2) {
                $pairValues[] = (int) $key;
            }
        }
        return $pairValues;
    }

    private function valueOfXOfAKind(array $arrayCountValues, int $x): int
    {
        $returnValue = 0;
        foreach ($arrayCountValues as $key => $value) {
            if ($value === $x) {
                $returnValue = (int) $key;
            }
        }
        return $returnValue;
    }

    private function countXOfAKind(array $arrayCountValues, int $x): int
    {
        return count(array_keys(array_values($arrayCountValues), $x));
    }

    private function nrOfPairs(array $arrayCountValues): int
    {
        return $this->countXOfAKind($arrayCountValues, 2);
    }

    private function nrOfAKind(array $arrayCountValues, int $value): int
    {
        return $arrayCountValues[$value] ?? 0;
        // return count(array_keys(array_values($arrayCountValues), $value));
    }

    private function calculateTwoPairs(array $arrayCountValues): int
    {
        $values = array_values($arrayCountValues);
        $nrOfPairs = $this->nrOfPairs($arrayCountValues);
        $pairValues = $this->getAllPairValues($arrayCountValues);
        $score = 0;
        if ($nrOfPairs === 2) {
            $score = 2 * ($pairValues[0] + $pairValues[1]);
        } elseif (in_array(2, $values) && in_array(3, $values)) {
            $score = 2 * (array_search(2, $arrayCountValues) + array_search(3, $arrayCountValues));
        }
        return $score;
    }

    public function isSlotEnabled(int $rowNr): bool
    {
        return !$this->disabledSlots[$rowNr];
    }

    public function isAnySlotAvailableAllowedAndEnabled(array $hand): bool
    {
        $availableAllowedAndEnabled = false;
        // exclude chance
        for ($i = 0; $i < $this::ROWS - 1; $i += 1) {
            if (!$this->disabledSlots[$i] && !$this->occupiedSlots[$i] && $this->isSlotAllowed($i, $hand)) {
                $availableAllowedAndEnabled = true;
                break;
            }
        }
        return $availableAllowedAndEnabled;
    }

    public function isChanceAvailableAndEnabled(): bool
    {
        // $this::ROWS - 1 => chance row
        $chanceAE = false;
        if (!$this->occupiedSlots[$this::ROWS - 1] && !$this->disabledSlots[$this::ROWS - 1]) {
            $chanceAE = true;
        }
        return $chanceAE;
    }
}
