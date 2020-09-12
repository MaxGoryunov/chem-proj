<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= LIBS; ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= CSS; ?>common/header.css">
    <link rel="stylesheet" href="<?= CSS; ?>common/page.css">
    <link rel="stylesheet" href="<?= CSS; ?>common/index.css">
    <? if (isset($cssFile)): ?>
    <link rel="stylesheet" href="<?= CSS . $cssFile; ?>.css">
    <? endif; ?>
    <title><?= $title; ?></title>
</head>
<body>
    <header class="header">
        <div class="header__logoblock"></div>
        <form action="" class="header__form"></form>
        <div class="header__navblock">
            <div class="header__navitem">Lorem, ipsum.</div>
            <div class="header__navitem">Eum, ipsum.</div>
            <div class="header__navitem">Reprehenderit, alias.</div>
            <div class="header__navitem">Laborum, doloribus?</div>
        </div>
    </header>
