<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
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
        public function getList(int $limit, int $offset):array {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new SelectQueryBuilder($this->getTableName()))
                          ->whereAnd("`gender_is_deleted`")
                          ->limit($limit, $offset)
                          ->build();

            $result      = $connection->query($query->getQueryString());
            $gendersList = $result->fetch_all(MYSQLI_ASSOC);

            return $gendersList;
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