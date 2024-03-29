<?php

    namespace Factories;

    use DataMappers\IDataMapper;

    /**
     * Interface for Factories which can create Data Mappers
     */
    interface IDataMapperFactory {
        
        /**
         * Returns a specified Data Mapper
         *
         * @return IDataMapper
         */
        public function getDataMapper():IDataMapper;
    }
