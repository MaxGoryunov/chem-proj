<?php

    namespace Entities;
    
    /**
     * Database Gender Entity
     */
    class GenderEntity extends AbstractEntity {

        /**
         * Name of the Gender
         *
         * @var string
         */
        public $name = "";

        /**
         * Short name of the Gender
         *
         * @var string
         */
        public $shortName = "";

        /**
         * Stores the deletion state of the Gender
         *
         * @var string
         */
        public $isDeleted = "";

        /**
         * {@inheritDoc}
         */
        protected function getType():string {
            return "Gender";
        }
    }