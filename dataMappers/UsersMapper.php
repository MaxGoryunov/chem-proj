<?php

    namespace DataMappers;

    use Entities\IEntity;
    use Entities\UserEntity;

    class UsersMapper extends AbstractDataMapper {

        public function mapDatasetToEntity(array $data = []):IEntity {
            return new UserEntity();
        }
    }