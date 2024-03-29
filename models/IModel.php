<?php

    namespace Models;

    use Entities\IEntity;

    /**
     * Interface specifies common Model methods
     */
    interface IModel {

        /**
         * Returns related table name
         *
         * @return string
         */
        public function getTableName():string;
        
        /**
         * Gets a list of Database Table Entities
         *
         * @param int    $limit number of entities to retrieve from the database
         * @param string $uri   request uri
         * @return IEntity[]
         */
        public function getList(int $limit, string $uri):array;

        /**
         * Returns a specific Database Table Entity
         *
         * @param int $id - id of the Entity
         * @return IEntity
         */
        public function getById(int $id):IEntity;

        /**
         * Adds Entity to database
         *
         * @param array $data
         * @return void
         */
        public function add(array $data = []):void;

        /**
         * Edits Entity based on the supplied data
         *
         * @param array $data - Entity data
         * @param int   $id   - Entity id
         * @return void
         */
        public function edit(array $data = [], int $id):void;

        /**
         * Function does not actually delete the Entity from the Database: instead it sets a specific field to a DELETED status
         *
         * @param int $id - id of the Entity
         * @return void
         */
        public function delete(int $id):void;
        
    }
