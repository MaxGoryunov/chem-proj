<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
    use Entities\IEntity;
    use Entities\UserEntity;

    /**
     * Class containing Users business logic 
     */
    class UsersModel extends AbstractModel {

        /**
         * {@inheritDoc}
         */
        protected $tableName = "users";

        /**
         * {@inheritDoc}
         * @return UserEntity[]
         */
        public function getList(int $limit, int $offset):array {
            return [];
        }

        /**
         * {@inheritDoc}
         * @return UserEntity
         */
        public function getById(int $id):IEntity {
            return new UserEntity();
        }

        /**
         * {@inheritDoc}
         */
        public function add(array $data = []):void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function edit(array $data = []):void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            
        }

        /**
         * Returns User's Admin Status based on User's SESSION
         *
         * @param int $userId
         * @return bool
         */
        public function getUserAdminStatus(int $userId = 0):bool {
            if ($userId == 0) {
                return false;
            }

            $connection = DBConnectionProvider::getConnection(IDBConnection::class);
            $what       = ["user_is_admin"];

            $query      = (new SelectQueryBuilder($this->getTableName()))
                          ->what($what)
                          ->whereAnd("`user_id` = " . $userId)
                          ->build();

            $res         = mysqli_query($connection, $query->getQueryString());
            $userIsAdmin = mysqli_fetch_assoc($res)['user_is_admin'];

            return (bool)$userIsAdmin;
        }
    }