<?php

    namespace Routing;

    /**
     * Class containing routing constants which lead to templates/ folder
     */
    class TemplatesRoutes {
        
        /**
         * Route to templates/
         */
        public const TEMPLATES = CommonRoutes::SITE_ROOT . "templates/";

        /**
         * Route to templates/common/
         */
        public const COMMON = TemplatesRoutes::TEMPLATES . "common/";

        /**
         * Route to templates/addresses/
         */
        public const ADDRESSES = TemplatesRoutes::TEMPLATES . "addresses/";

        /**
         * Route to templates/genders/
         */
        public const GENDERS = TemplatesRoutes::TEMPLATES . "genders/";

        /**
         * Route to templates/user_statuses/
         */
        public const USER_STATUSES = TemplatesRoutes::TEMPLATES . "user_statuses/";
    }