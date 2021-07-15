<?php

    namespace Routing;

    use Components\Router;
use ControllerActions\ControllerAction;
use Factories\AddressesFactory;
use Factories\DomainFactory;
use Factories\GendersFactory;
    use Factories\UserStatusesFactory;

    /**
     * Class for handling factory names in user URI
     */
    class FactoryHandler extends AbstractHandler {

        /**
         * Allowed Factories
         * 
         * @var array<string, string>
         */
        private array $factories;

        /**
         * Ctor.
         *
         * @param array<string, AbstractMVCPDMFactory> $factories
         */
        public function __construct(
            array $factories = [
                "addresses"     => DomainFactory::class,
                "genders"       => DomainFactory::class,
                "user_statuses" => DomainFactory::class
            ]
        ) {
            $this->factories = $factories;
        }

        /**
         * {@inheritDoc}
         */
        protected function fillData(array $partedUri, ControllerAction $action):ControllerAction {
            $factory = $this->factories[$partedUri[2]] ?? null;

            if (isset($factory)) {
                $action->setFactory(new $factory($partedUri[2]));
            } else {
                Router::headerTo("./errors/not_found");
            }

            return $action;
        }
    }
