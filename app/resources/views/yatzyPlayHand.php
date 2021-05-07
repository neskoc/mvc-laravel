<?php

/**
 * View template for Dice Game.
 */

declare(strict_types=1);

namespace App\Models\Yatzy;

$playerNr = $playerNr ?? 1;
$round = $round ?? 1;
$rollNr = $rollNr ?? 1;
$header = $header ?? null;
$message = $message ?? null;
$debug = $debug ?? null;

?>

<section>
<h1><?= $header ?></h1>

<h2>Spelare: <?= $playerNr ?>, Omgång: <?= $round ?>,  Slag: <?= $rollNr ?></h2>
<?php
if ($debug != null) {
    echo("Debug:" . $debug);
}
?>

<form action="" method="POST">
    <?php
    if ($rollNr < 3) {
        echo('<input name="playHand" type="submit" value="Slå tärningar">');
    }
    ?>
    <button type="submit" formaction="save" value="save">Stanna</button>
    <?= $hand ?>

    <div>
        <?= $table ?>
    </div>
</form>

</section>
