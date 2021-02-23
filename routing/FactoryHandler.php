<?php

    namespace Routing;

    use Components\Router;
use ControllerActions\ControllerAction;
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
        protected function fillData(array $partedUri, ControllerAction $action):ControllerAction {
            $factory = self::FACTORIES[$partedUri[2]] ?? null;

            if (isset($factory)) {
                $action->setFactory(new $factory());
            } else {
                Router::headerTo("./errors/not_found");
            }

            return $action;
        }
    }