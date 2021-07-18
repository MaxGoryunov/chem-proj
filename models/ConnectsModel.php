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
    class ConnectsModel extends AbstractModel implements IModel {

        /**
         * Ctor.
         */
        public function __construct(string $table = "connects") {
            $this->table = $table;
        }

        /**
         * {@inheritDoc}
         */
        protected function getDomainName():string {
            return "connect";
        }

        /**
         * {@inheritDoc}
         */
        public function getList(int $limit, string $uri): array
        {
            return [];
        }

        /**
         * {@inheritDoc}
         */
        public function getById(int $id): IEntity
        {
            return new class implements IEntity {};
        }

        /**
         * {@inheritDoc}
         */
        public function add(array $data = []):void {
            $connection   = $this->connectToDB();
            $data["time"] = "FROM_UNIXTIME(" . $data["time"] . ")";

            $query      = (new InsertQueryBuilder($this->getTableName()))
                            ->set($data)
                            ->build();
                
			$connection->query($query->getQueryString());
        }

        /**
         * {@inheritDoc}
         */
        public function edit(array $data = [], int $id): void
        {
            
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
            return (bool)$this->connectToDB()->query(
                (new SelectQueryBuilder($this))
                ->where("`connect_user_id` = " . $userId)
                ->and("`connect_token` = '$token'")
                ->and("`connect_session_id` = '$sessionId'")
            )->fetch_assoc();
        }
    }