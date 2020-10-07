<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\InsertQueryBuilder;
    use DBQueries\SelectQueryBuilder;
    use DBQueries\UpdateQueryBuilder;
    use Entities\AddressEntity;
    use Entities\IEntity;

    /**
     * Model containing Addresses business logic
     */
    class AddressesModel extends AbstractModel {

        /**
         * {@inheritDoc}
         */
        protected $tableName = "addresses";
        
        /**
         * {@inheritDoc}
         * 
         * @return AddressEntity[]
         */
        public function getList(int $limit, int $offset):array {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new SelectQueryBuilder($this->getTableName()))
                            ->whereAnd("`address_is_deleted` = 0")
                            ->limit($limit, $offset)
                            ->build();

            $result        = $connection->query($query->getQueryString());
            $addressesList = $result->fetch_all(MYSQLI_ASSOC);

            return $addressesList;
        }

        /**
         * {@inheritDoc}
         * 
         * @return AddressEntity
         */
        public function getById(int $id):IEntity {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new SelectQueryBuilder($this->getTableName()))
                            ->whereAnd("`address_is_deleted` = 0")
                            ->whereAnd("`address_id` = " . $id)
                            ->build();

            $result          = $connection->query($query->getQueryString());
            $addressData     = $result->fetch_assoc();
            $addressesMapper = $this->getDataMapper();
            $addressEntity   = $addressesMapper->mapDatasetToEntity($addressData);
            
			return $addressEntity;
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
                          ->whereAnd("`address_id` = " . $data["id"])
                          ->build();
                        
            $connection->query($query->getQueryString());
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            
        }
    }