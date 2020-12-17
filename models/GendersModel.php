<?php

    namespace Models;

    use Entities\IEntity;

    /**
     * Model containing Genders business logic
     */
    class GendersModel extends AbstractModel {
        
        /**
         * {@inheritDoc}
         */
        protected $tableName = "genders";

        /**
         * {@inheritDoc}
         */
        protected function getDomainName():string {
            return "gender";
        }

        /**
         * {@inheritDoc}
         */
        public function getById(int $id):IEntity {
            return new class implements IEntity {};
        }
    }