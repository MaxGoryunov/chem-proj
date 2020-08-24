<?php

    /**
     * @todo Implement Data Mapper interface
     */
    /**
     * This interface is used by almost all factories
     * 
     * MVCPDM stands for Model - View - Controller - Proxy - Data Mapper
     */
    interface IMVCPDMCompleteFactory extends IVCIncompleteFactory {
        
        public function getModel():AbstractModel;

        public function getProxy():AbstractProxyController;
    }