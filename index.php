<?php

    include_once("./components/Autoloader.php");
    include_once("./config/constants.php");

    Autoloader::register();

    $router = new Router();

    $router->run();