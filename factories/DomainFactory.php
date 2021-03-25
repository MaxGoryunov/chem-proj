<?php

    namespace Factories;

use Components\Domain;
use Components\DomainRegistry;
use Controllers\DomainController;
use Controllers\IController;
use DataMappers\DomainMapper;
use DataMappers\IDataMapper;
use Models\DomainModel;
use Models\IModel;
use ProxyControllers\DomainProxyController;
use Views\DomainView;
use Views\IView;

/**
     * Class for creating domain components
     */
    class DomainFactory extends AbstractMVCPDMFactory {

        /**
         * Domain to which the factory belongs
         *
         * @var string
         */
        private $domain;

        /**
         * @param string $domain
         */
        public function __construct(string $domain) {
            $this->domain = $domain;
        }

        /**
         * {@inheritDoc}
         * 
         * @todo Change DomainModel constructor
         */
        public function getModel():IModel {
            return new DomainModel($this->domain, $this);
        }

        /**
         * {@inheritDoc}
         */
        public function getView():IView {
            return new DomainView($this->domain);
        }

        /**
         * {@inheritDoc}
         */
        public function getController():IController {
            return new DomainController($this, $this->domain);
        }

        /**
         * {@inheritDoc}
         */
        public function getProxy():IController {
            return new DomainProxyController($this);
        }

        /**
         * {@inheritDoc}
         */
        public function getDataMapper():IDataMapper {
            return new DomainMapper($this->domain);
        }

        /**
         * {@inheritDoc}
         */
        public function getDomain():Domain {
            return (new DomainRegistry())->getDomain($this->domain);
        }
    }