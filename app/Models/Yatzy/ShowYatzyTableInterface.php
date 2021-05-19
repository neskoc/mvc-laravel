<?php

declare(strict_types=1);

namespace App\Models\Yatzy;

/**
 * ShowYatzyTableInterface
 */

interface ShowYatzyTableInterface
{
    public function showYatzyTable(YatzyTable $yatzyTable, YatzyGame $yatzyGame): string;
}
