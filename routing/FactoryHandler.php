<?php

    namespace Routing;

use Components\Router;
use Factories\AddressesFactory;
use Factories\GendersFactory;
use Factories\UserStatusesFactory;

/**
     * Class for handling factory names in user URI
     */
    class FactoryHandler extends AbstractHandler {

        /**
         * Contains allowed factories
         * 
         * @var string[]
         */
        private const FACTORIES = [
            "addresses"     => AddressesFactory::class,
            "genders"       => GendersFactory::class,
            "user_statuses" => UserStatusesFactory::class
        ];
        
        /**
         * {@inheritDoc}
         */
        public function handle(array $partedUri, array $invokeData = []):array {
            if (isset(self::FACTORIES[$partedUri[2]])) {
                $invokeData["factory"] = self::FACTORIES[$partedUri[2]];
            } else {
                /**
                 * @todo Implement error pages
                 */
                Router::headerTo("./errors/not_found");
            }

            return $this->passToNext($partedUri, $invokeData);
        }
    }