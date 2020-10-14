<?php

    namespace Routing;

    /**
     * Class containing routing constants which lead to assets/ folders
     */
    class AssetsRoutes {
        
        /**
         * Route to the folder with css code 
         */
        public const CSS = CommonRoutes::SITE_ROOT . "assets/css/";

        /**
         * Route to the folder with images
         */
        public const IMG = CommonRoutes::SITE_ROOT . "assets/img/";

        /**
         * Route to the folder with js code
         */
        public const JS = CommonRoutes::SITE_ROOT . "assets/js/";

        /**
         * Route to the folder with different libraries
         */
        public const LIBS = CommonRoutes::SITE_ROOT . "assets/libs/";
    }