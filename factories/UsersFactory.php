<?php

    namespace Factories;

use Components\Domain;
use Components\DomainRegistry;
use Controllers\IController;
    use Controllers\UsersController;
    use DataMappers\IDataMapper;
    use DataMappers\UsersMapper;
    use Models\IModel;
    use Models\UsersModel;
    use ProxyControllers\UsersProxyController;
    use Views\IView;
    use Views\UsersView;

    /**
     * Class for creating components from Users domain
     */
    class UsersFactory extends AbstractMVCPDMFactory {

        /**
         * {@inheritDoc}
         */
        public function domainString(): string
        {
            return "users";
        }

        /**
         * Returns a Users Model
         *
         * @return UsersModel
         */
        public function getModel():IModel {
            return new UsersModel("users", $this);
        }

        public function getView():IView {
            return new UsersView();
        }

        public function getController():IController {
            return new UsersController($this);
        }

        public function getProxy():IController {
            return new UsersProxyController($this);
        }

        public function getDataMapper():IDataMapper {
            return new UsersMapper();
        }

        public function getDomain(): Domain
        {
            return (new DomainRegistry())->getDomain("users");
        }

    }