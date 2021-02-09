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
    }