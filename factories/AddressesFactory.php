<?php

    /**
     * Factory for getting classes from Addresses Domain
     */
    class AddressesFactory implements IMVCPDMFactory {
        
        public function getModel():AddressesModel {
            return new AddressesModel();
        }

        public function getView():AddressesView {
            return new AddressesView();
        }

        public function getController():AddressesController {
            return new AddressesController();
        }

        public function getProxy():AddressesProxyController {
            return new AddressesProxyController();
        }

        public function getDataMapper():AddressesMapper {
            return new AddressesMapper();
        }
    }