<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
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

			$res           = mysqli_query($connection, $query->getQueryString());
			$addressesList = mysqli_fetch_all($res, MYSQLI_ASSOC);

            return $addressesList;
        }

        /**
         * {@inheritDoc}
         * 
         * @return AddressEntity
         */
        public function getById(int $id):IEntity {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new SelectQueryBuilder("addresses"))
                            ->whereAnd("`address_is_deleted` = 0")
                            ->whereAnd("`address_id` = " . $id)
                            ->build();

			$res             = mysqli_query($connection, $query);
            $addressData     = mysqli_fetch_assoc($res);
            $addressesMapper = $this->getDataMapper();
            $addressEntity   = $addressesMapper->mapDatasetToEntity($addressData);
            
			return $addressEntity;
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