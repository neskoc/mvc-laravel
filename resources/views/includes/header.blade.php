<!doctype html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?? "mvc" ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= url("/favicon.ico") ?>">
    <link rel="stylesheet" type="text/css" href="<?= url("/css/style.css") ?>">
</head>

<body>

<header>
    <nav>
        <a href="{{ route("game21") }}">Game 21</a> |
        <a href="{{ route("yatzy") }}">Yatzy</a>
    </nav>
</header>
<main>
