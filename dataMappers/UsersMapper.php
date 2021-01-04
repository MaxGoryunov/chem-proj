<?php

    namespace DataMappers;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
    use Entities\UserEntity;

    /**
     * Data Mapper for mapping User Entity objects
     */
    class UsersMapper extends AbstractDataMapper {

        /**
         * {@inheritDoc}
         * 
         * @return UserEntity
         */
        public function mapQueryResultToEntity(SelectQueryBuilder $builder):UserEntity {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);
            $query      = $builder->build();

            $result = $connection->query($query->getQueryString());
            $entity = $result->fetch_object(UserEntity::class);

            return $entity;
        }
    }