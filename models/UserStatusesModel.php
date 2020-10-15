<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\InsertQueryBuilder;
    use DBQueries\SelectQueryBuilder;
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

        public function getList(int $limit, int $offset):array {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new SelectQueryBuilder($this->getTableName()))
                          ->whereAnd("`user_status_is_deleted` = 0")
                          ->limit($limit, $offset)
                          ->build();

            $result           = $connection->query($query->getQueryString());
            $userStatusesList = $result->fetch_all(MYSQLI_ASSOC);

            return $userStatusesList;
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
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new InsertQueryBuilder($this->getTableName()))
                          ->set($data)
                          ->build();

            $connection->query($query->getQueryString());
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