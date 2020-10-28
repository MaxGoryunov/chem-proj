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

        /**
         * {@inheritDoc}
         */
        public function edit(array $data = []):void {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new UpdateQueryBuilder($this->getTableName()))
                          ->set($data)
                          ->whereAnd("`user_status_id` = " . $data["id"])
                          ->build();
                        
            $connection->query($query->getQueryString());
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new UpdateQueryBuilder($this->getTableName()))
                          ->set(["user_status_is_deleted" => 1])
                          ->whereAnd("`user_status_id` = " . $id)
                          ->build();

            $connection->query($query->getQueryString());
        }
    }