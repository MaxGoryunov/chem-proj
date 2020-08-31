<?php

    /**
     * Interface specifies common Data Mapper methods
     */
    interface IDataMapper {
        
        /**
         * Based on received dataset creates a new UserEntity
         *
         * @param array $data
         * 
         * @return IEntity
         */
        public function mapDatasetToEntity(array $data = []):IEntity;
    }