<?php

    /**
     * @author Max Goriunov
     */

    use Components\Autoloader;
    use Components\Router;

    /**
     * @todo Add working email address
     */
    include_once("./components/Autoloader.php");
    include_once("./config/constants.php");

    $autoloader = new Autoloader();

    /**
     * Registering an autoloader function
     */
    $autoloader->register();

    $router = new Router();

    $router->run();

    include_once("./templates/common/header.php");
    include_once("./templates/errors/notAdmin.php");