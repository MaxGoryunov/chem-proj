<?php

    /**
     * Factory for getting classes from Addresses Domain
     */
    class AddressesFactory extends AbstractMVCPDMFactory {
        
        /**
         * Get a Model from Address domain
         *
         * @return AddressesModel
         */
        public function getModel():IModel {
            return new AddressesModel();
        }

        /**
         * Get a View from Address domain
         *
         * @return AddressesView
         */
        public function getView():IView {
            return new AddressesView();
        }

        /**
         * Get a Controller from Address domain
         *
         * @return AddressesController
         */
        public function getController():IController {
            return new AddressesController($this);
        }

        /**
         * Get a Proxy Controller from Address domain
         *
         * @return AddressesProxyController
         */
        public function getProxy():IController {
            return new AddressesProxyController($this);
        }

        /**
         * Get a Data Mapper from Address domain
         *
         * @return AddressesMapper
         */
        public function getDataMapper():IDataMapper {
            return new AddressesMapper();
        }
    }