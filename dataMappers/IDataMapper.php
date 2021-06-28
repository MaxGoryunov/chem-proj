<?php

    namespace DataMappers;

    use DBQueries\SelectQueryBuilder;
    use Entities\IEntity;

    /**
     * Interface specifies common Data Mapper methods
     */
    interface IDataMapper {

        /**
         * Creates a new Entity based on DB query results
         *
         * @param SelectQueryBuilder $builder
         * @return IEntity
         */
        public function mapQueryResultToEntity(SelectQueryBuilder $builder):IEntity;
    }