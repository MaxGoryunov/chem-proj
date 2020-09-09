<?php

    /**
     * Base class for implementing other Models
     */
    abstract class AbstractModel implements IModel {
        
        /**
         * Contains name of related Database Table
         *
         * @var string
         */
        protected $tableName = "";

        /**
         * Returns a name of related Database Table
         *
         * @return string
         */
        protected function getTableName():string {
            return $this->tableName;
        }

        /**
         * Returns number of rows in a table
         *
         * @return int
         */
        public function calculateRecordCount():int {
            $connection = DBConnectionProvider::getConnection(IDBConnection::class);
            $columns    = ["count" => "count(*)"];

            $query      = (new SelectQueryBuilder($this->getTableName()))
                            ->what($columns)
                            ->build();

			$res   = mysqli_query($connection, $query->getQueryString());
            $count = mysqli_fetch_assoc($res)['count'];
            
			return $count;
        }

        /**
         * Returns the number of the current
         *
         * @return int
         */
        public function getCurrentPageNumber():int {
            $requestUri = $_SERVER['REQUEST_URI'];
			$uriParted  = explode('/', $requestUri);
			$pageString = $uriParted[count($uriParted) - 1];
			$pageParted = explode('=', $pageString);
            $pageNumber = $pageParted[1] ?? 1;
            
			return $pageNumber;
        }
    }