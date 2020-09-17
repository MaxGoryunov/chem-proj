<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= LIBS; ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= LIBS; ?>/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="<?= LIBS; ?>/fontawesome/css/solid.css">
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
            <div class="header__navitem header__navitem--selected">
                <a href="" class="header__link">
                    <div class="header__icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="header__text">Адреса</div>
                </a>
            </div><div class="header__navitem">
                <a href="" class="header__link">
                    <div class="header__icon"><i class="fas fa-venus-mars"></i></div>
                    <div class="header__text">Гендеры</div>
                </a>
            </div><div class="header__navitem">
                <a href="" class="header__link">
                    <div class="header__icon"><i class="fas fa-user-tag"></i></div>
                    <div class="header__text">Статусы</div>
                </a>
            </div><div class="header__navitem">
                <a href="" class="header__link">
                    <div class="header__icon"><i class="fas fa-users"></i></div>
                    <div class="header__text">Пользователи</div>
                </a>
            </div>
        </div>
    </header>
