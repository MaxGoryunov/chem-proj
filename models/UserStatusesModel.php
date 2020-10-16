<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
    use Entities\IEntity;

    /**
     * Model containing User Statuses business logic
     */
    class UserStatusesModel extends AbstractModel {

        /**
         * {@inheritDoc}
         */
        protected $tableName = "user_statuses";

        /**
         * {@inheritDoc}
         */
        protected function getDomainName():string {
            return "user_status";
        }

        /**
         * Stub method(yet)
         * {@inheritDoc}
         */
        public function getById(int $id):IEntity {
            return new class implements IEntity {};
        }

        /**
         * {@inheritDoc}
         */
        public function add(array $data = []):void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function edit(array $data = []):void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            
        }
    }