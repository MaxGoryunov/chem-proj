<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DBQueries\DeleteQueryBuilder;
    use DBQueries\InsertQueryBuilder;
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
        protected function getDomainName():string {
            return "connect";
        }
        /**
         * {@inheritDoc}
         */
        public function delete(int $userId):void {
            $connection = $this->connectToDB();

            $query = (new DeleteQueryBuilder($this->getTableName()))
                        ->whereAnd("`connect_user_id` = " . $userId)
                        ->build();

            $connection->query($query->getQueryString());
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
            $connection = $this->connectToDB();

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