<?php

    namespace DataMappers;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
    use Entities\AddressEntity;

    /**
     * Data Mapper for mapping AddressEntity objects
     */
    class AddressesMapper implements IDataMapper {
        
        /**
         * {@inheritDoc}
         * 
         * @return AddressEntity
         */
        public function mapQueryResultToEntity(SelectQueryBuilder $builder):AddressEntity {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);
            $query      = $builder->build();

            $result = $connection->query($query->getQueryString());
            $entity = $result->fetch_object(AddressEntity::class);

            return $entity;
        }
    }