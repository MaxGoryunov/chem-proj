<?php

    namespace Models;

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
         */
        protected function getDomainName():string {
            return "address";
        }

        /**
         * {@inheritDoc}
         * 
         * @return AddressEntity
         */
        public function getById(int $id):IEntity {
            $connection = $this->connectToDB();

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
            $connection = $this->connectToDB();

            $query      = (new InsertQueryBuilder($this->getTableName()))
                          ->set($data)
                          ->build();

            $connection->query($query->getQueryString());
        }

        /**
         * {@inheritDoc}
         */
        public function edit(array $data = []):void {
            $connection = $this->connectToDB();

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
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new UpdateQueryBuilder($this->getTableName()))
                          ->set(["address_is_deleted" => 1])
                          ->whereAnd("`address_id` = ". $id)
                          ->build();

			$connection->query($query->getQueryString());
        }
    }