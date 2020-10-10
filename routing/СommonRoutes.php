<?php

    namespace Routing;

    /**
     * Class containing common routing constants
     */
    class CommonRoutes {

        /**
         * Name of the folder of the developing project
         * 
         * @var string
         */
        public const ROOT = "/chem-proj/";

        /**
         * Complete prefix of all site routes
         * 
         * @var string
         */
        public const SITE_ROOT = "http://localhost" . CommonRoutes::ROOT;
    }