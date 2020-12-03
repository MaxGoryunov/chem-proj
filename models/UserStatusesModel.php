<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\InsertQueryBuilder;
    use DBQueries\UpdateQueryBuilder;
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
    }