<?php

    namespace DataMappers;

use Components\DBServiceProvider;
use Components\IDBConnection;
use DBQueries\SelectQueryBuilder;
    use Entities\AddressEntity;
    use Entities\GenderEntity;
    use Entities\IEntity;
    use Entities\UserEntity;
    use Entities\UserStatusEntity;

    /**
     * Base class for implementing other Data Mappers
     */
    class DomainMapper implements IDataMapper {

        /**
         * Allowed entity types
         * 
         * @var array<string, string>
         */
        private const ENTITY_TYPES = [
            "addresses"     => AddressEntity::class,
            "genders"       => GenderEntity::class,
            "users"         => UserEntity::class,
            "user_statuses" => UserStatusEntity::class
        ];

        /**
         * Contains type to which the result data will be mapped
         *
         * @var string
         */
        private $type;

        /**
         * @todo Add strict check for input type value
         *
         * @param string $type
         */
        public function __construct(string $type) {
            $this->type = $type;
        }

        /**
         * {@inheritDoc}
         */
        public function mapQueryResultToEntity(SelectQueryBuilder $builder):IEntity {
            $connection = (new DBServiceProvider())->getConnection(IDBConnection::class);
            $result     = $connection->query($builder);
            $entity     = $result->fetch_object(self::ENTITY_TYPES[$this->type]);

            return $entity;
        }
    }