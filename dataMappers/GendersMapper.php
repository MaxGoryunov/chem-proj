<?php

    namespace DataMappers;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
    use Entities\GenderEntity;

    /**
     * Data Mapper for mapping GenderEntity objects
     */
    class GendersMapper implements IDataMapper {

        /**
         * {@inheritDoc}
         * 
         * @return GenderEntity
         */
        public function mapQueryResultToEntity(SelectQueryBuilder $builder):GenderEntity {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);
            $query      = $builder->build();

            $result = $connection->query($query->getQueryString());
            $entity = $result->fetch_object(GenderEntity::class);

            return $entity;
        }
    }