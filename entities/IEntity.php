<?php

    namespace Entities;
    
    /**
     * Interface for Database Table Entities
     */
    interface IEntity {

        /**
         * Returns Entity's unique id
         *
         * @return int
         */
        public function getId():int;
    }