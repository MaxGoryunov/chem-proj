<?php

    namespace Factories;

    use Models\IModel;

    /**
     * Interface for Factories which can create Models
     */
    interface IModelFactory {
        
        /**
         * Returns a specified Model
         *
         * @return IModel
         */
        public function getModel():IModel;
    }
