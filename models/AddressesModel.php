<?php

    namespace Models;

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
    }