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

    (new Autoloader())->register();
    (new Router())->run($_SERVER["REQUEST_URI"]);