<?php

/**
 * View template for Dice Game.
 */

declare(strict_types=1);

namespace App\Models\Yatzy;

$header = $header ?? null;
$message = $message ?? null;
$debug = $debug ?? null;

?>

<section>
<h1><?= $header ?></h1>

<h2>Spelet är slut!</h2>
<?php
if ($debug != null) {
    echo("Debug:" . $debug);
}
?>

<div>
    <?= $table ?>
</div>

</section>
