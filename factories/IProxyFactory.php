<?php

    namespace Factories;

    use Controllers\IController;

    /**
     * Interface for Factories which can create Controller Proxies
     */
    interface IProxyFactory extends IControllerFactory {
        
        /**
         * Returns a specified Controller Proxy
         *
         * @return IController
         */
        public function getProxy():IController;
    }