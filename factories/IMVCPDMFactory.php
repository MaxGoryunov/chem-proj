<?php

    namespace Factories;

    use Controllers\IController;
    use DataMappers\IDataMapper;
    use Models\IModel;
    use Views\IView;

    /**
     * This interface is used by all factories
     * 
     * MVCPDM stands for Model - View - Controller - Proxy - Data Mapper
     */
    interface IMVCPDMFactory {
        
        /**
         * Returns a specified Model
         *
         * @return IModel
         */
        public function getModel():IModel;

        /**
         * Returns a specified View
         *
         * @return IView
         */
        public function getView():IView;

        /**
         * Returns a specified Controller
         *
         * @return IController
         */
        public function getController():IController;

        /**
         * Returns a specified ProxyController
         *
         * @return IController
         */
        public function getProxy():IController;

        /**
         * Returns a specifies Data Mapper
         *
         * @return IDataMapper
         */
        public function getDataMapper():IDataMapper;
        
    }