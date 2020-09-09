<?php

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
            return new AddressEntity();
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