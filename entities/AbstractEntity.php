<?php

    namespace Entities;
    
    /**
     * Base class for implementing other Entities
     */
    abstract class AbstractEntity {
        
        /**
         * Unique id of object
         *
         * @var int
         */
        protected $id;
    }