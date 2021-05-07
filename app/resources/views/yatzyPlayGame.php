<?php

/**
 * View template for Dice Game.
 */

declare(strict_types=1);

namespace App\Models\Yatzy;

$header = $header ?? null;
$message = $message ?? null;

?>

<h1><?= $header ?></h1>

<h2><?= $message ?></h2>

<div class="container-table100" data-pattern="priority-columns">
    <div class="wrap-table100">
        <?= $table ?>
    </div>
</dv>

<form action="#" method="POST">
    <input name="playGame" type="submit" value="Spela">
</form>
<br>
