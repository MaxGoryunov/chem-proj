<?php

    namespace Components;

use InvalidArgumentException;

class RoutePackage {

        /**
         * Contains domain name to which this route package corresponds
         *
         * @var string
         */
        private $domain = "";

        /**
         * Contains factory name which creates components from $domain domain
         *
         * @var string
         */
        private $factory = "";

        /**
         * Contains routes and corresponding actions from $domain domain
         *
         * @var string[]
         */
        private $routes = [];

        /**
         * Undocumented function
         *
         * @param string $domain
         * @param string $factory
         */
        public function __construct(string $domain = "", string $factory = "") {
            if ($domain === "") {
                throw new InvalidArgumentException("Domain must be a valid string");
            }

            if ($factory === "") {
                throw new InvalidArgumentException("Factory must be a valid string");
            }

            $this->domain  = $domain;
            $this->factory = $factory;
        }

        /**
         * Adds route and action which is called from it
         *
         * @param string $route
         * @param string $action
         * @return void
         */
        public function addRoute(string $route, string $action):void {
            $this->routes[$route] = $action;
        }

        /**
         * Returns action based on the supplied route
         *
         * @param string $route
         * @return string
         */
        public function getActionByRoute(string $route):string {
            return $this->routes[$route] ?? null;
        }

        /**
         * Returns domain name of this route package
         *
         * @return string
         */
        public function getDomain():string {
            return $this->domain;
        }

        /**
         * Returns factory name of this route package
         *
         * @return string
         */
        public function getFactory():string {
            return $this->factory;
        }
    }