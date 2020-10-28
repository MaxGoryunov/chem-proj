<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\InsertQueryBuilder;
    use DBQueries\UpdateQueryBuilder;
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
                          ->whereAnd("`gender_id` = " . $data["id"])
                          ->build();

            $connection->query($query->getQueryString());
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new UpdateQueryBuilder($this->getTableName()))
                          ->set(["gender_is_deleted" => 1])
                          ->whereAnd("`gender_id` = " . $id)
                          ->build();

            $connection->query($query->getQueryString());
        }
    }