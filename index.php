<?php

/**
 * @author Max Goriunov
 */

use Components\Autoloader;
use Routing\BsRouter;
use Routing\NonEmptyRouter;
use Routing\Router;

/**
 * @todo Add working email address
 */
include_once("./components/Autoloader.php");
include_once("./config/constants.php");

(new Autoloader())->register();
(new NonEmptyRouter(
    new BsRouter()
))
    ->run($_SERVER["REQUEST_URI"] ?? "");
