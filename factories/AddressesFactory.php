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
        public function getModel():AddressesModel {
            return new AddressesModel();
        }

        /**
         * Get a View from Address domain
         *
         * @return AddressesView
         */
        public function getView():AddressesView {
            return new AddressesView();
        }

        /**
         * Get a Controller from Address domain
         *
         * @return AddressesController
         */
        public function getController():AddressesController {
            return new AddressesController($this);
        }

        /**
         * Get a Proxy Controller from Address domain
         *
         * @return AddressesProxyController
         */
        public function getProxy():AddressesProxyController {
            return new AddressesProxyController();
        }

        /**
         * Get a Data Mapper from Address domain
         *
         * @return AddressesMapper
         */
        public function getDataMapper():AddressesMapper {
            return new AddressesMapper();
        }
    }