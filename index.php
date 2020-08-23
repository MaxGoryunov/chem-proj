<?php

    include_once("./components/Autoloader.php");
    include_once("./config/constants.php");

    $autoloader = new Autoloader();
    $autoloader->register();

    $router = new Router();

    $router->run();