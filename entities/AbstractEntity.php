<?php

    namespace Entities;
    
    /**
     * Base class for implementing other Entities
     */
    abstract class AbstractEntity implements IEntity {
        
        /**
         * Unique id of object
         *
         * @var int
         */
        protected $id = 0;

        /**
         * {@inheritDoc}
         */
        public function getId():int {
            return $this->id;
        }
    }