<?php

    namespace Models;
    
    /**
     * Base class for implementing other Models
     */
    abstract class AbstractModel implements IModel {

        /**
         * Returns related table name
         *
         * @return string
         */
        public abstract function getTableName():string;
    }