<?php

    namespace DataMappers;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
    use Entities\IEntity;
    use Entities\UserStatusEntity;

    /**
     * Data Mapper for mapping UserStatusEntity objects
     */
    class UserStatusesMapper implements IDataMapper {

        /**
         * {@inheritDoc}
         * 
         * @return UserStatusEntity
         */
        public function mapQueryResultToEntity(SelectQueryBuilder $builder):IEntity {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);
            $query      = $builder->build();

            $result = $connection->query($query->getQueryString());
            $entity = $result->fetch_object(UserStatusEntity::class);

            return $entity;
        }
    }