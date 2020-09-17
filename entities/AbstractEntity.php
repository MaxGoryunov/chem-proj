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
         * Accepts Entity's id
         *
         * @param int $id
         */
        public function __construct(int $id) {
            $this->id = $id;
        }

        /**
         * {@inheritDoc}
         */
        public function getId():int {
            return $this->id;
        }
    }