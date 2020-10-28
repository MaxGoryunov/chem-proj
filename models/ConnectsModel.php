<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\SelectQueryBuilder;
    use Entities\IEntity;

    /**
     * Class containing Connects business logic
     */
    class ConnectsModel extends AbstractModel {

        /**
         * {@inheritDoc}
         */
        protected $tableName = "connects";

        /**
         * {@inheritDoc}
         */
        public function getList(int $limit, int $offset):array {
            return [];
        }

        /**
         * {@inheritDoc}
         */
        public function getById(int $id):IEntity {
            return new class implements IEntity {};
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
         * Returns User's Authorisation Status
         *
         * @param int $userId - id of the user to be checked
         * @param string $token - unique string which assures user's authorisation
         * @param string $sessionId - session id unique per user
         * @return bool
         */
        public function getUserAuthStatus(int $userId, string $token, string $sessionId):bool {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);

            $query      = (new SelectQueryBuilder($this->getTableName()))
                          ->whereAnd("`connect_user_id` = " . $userId)
                          ->whereAnd("`connect_token` = '$token'")
                          ->whereAnd("`connect_session_id` = '$sessionId'")
                          ->build();
            
            $res          = mysqli_query($connection, $query->getQueryString());
            $contactInfo = mysqli_fetch_assoc($res);

            return ($contactInfo) ? true : false;
        }
    }