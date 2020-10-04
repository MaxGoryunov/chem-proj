<?php

    namespace DataMappers;
    
    use Entities\AddressEntity;

    /**
     * Data Mapper for mapping AddressEntity objects
     */
    class AddressesMapper implements IDataMapper {
        
        public function mapDatasetToEntity(array $data = []):AddressEntity {
            return new AddressEntity();
        }
    }