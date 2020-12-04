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
    }