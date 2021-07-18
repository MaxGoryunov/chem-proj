<?php

    namespace Controllers;
    
    /**
     * Interface specifies common Controller methods
     */
    interface IController {
        
        /**
         * Controls the presentation process of the Entities from the DB
         *
         * @return void
         */
        public function index():void;

        /**
         * Controls the editing process of an Entity based on id
         *
         * @param int $id - id of the Entity to be edited
         * @return void
         */
        public function edit(int $id):void;

        /**
         * Controls the creation of Entity
         *
         * @return void
         */
        public function add():void;

        /**
         * Controls the deletion process of an Entity based on id
         *
         * @param int $id - id of the Entity to be deleted
         * @return void
         */
        public function delete(int $id):void;
    }
