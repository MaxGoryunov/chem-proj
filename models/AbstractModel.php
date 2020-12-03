<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DataMappers\AbstractDataMapper;
    use DBQueries\InsertQueryBuilder;
    use DBQueries\SelectQueryBuilder;
    use DBQueries\UpdateQueryBuilder;
    use Factories\AbstractMVCPDMFactory;
    use mysqli;
    use Traits\TableNameTrait;

    /**
     * Base class for implementing other Models
     */
    abstract class AbstractModel implements IModel {

        use TableNameTrait;
        
        /**
         * Related Factory used to get related Data Mapper
         *
         * @var AbstractMVCPDMFactory
         */
        protected $relatedFactory;

        /**
         * Related Data Mapper containing methods for mapping datasets to objects
         *
         * @var AbstractDataMapper
         */
        protected $relatedMapper;

        /**
         * Accepts the Factory to delegate it the creation of Data Mapper
         *
         * @param AbstractMVCPDMFactory $relatedFactory
         */
        public function __construct(AbstractMVCPDMFactory $relatedFactory = null) {
            $this->relatedFactory = $relatedFactory;
        }

        /**
         * Returns domain name in singular
         *
         * @return string
         */
        protected abstract function getDomainName():string;

        /**
         * Returns a related Data Mapper
         *
         * @return AbstractDataMapper
         */
        protected function getDataMapper():AbstractDataMapper {
            if (!isset($this->relatedMapper)) {
                $this->relatedMapper = $this->relatedFactory->getDataMapper();
            }

            return $this->relatedMapper;
        }

        /**
         * {@inheritDoc}
         */
        public function getList(int $limit, int $offset):array {
            $connection = $this->connectToDB();

            $query      = (new SelectQueryBuilder($this->getTableName()))
                            ->whereAnd("`" . $this->getDomainName() . "_is_deleted` = 0")
                            ->limit($limit, $offset)
                            ->build();

            $result    = $connection->query($query->getQueryString());
            $itemsList = $result->fetch_all(MYSQLI_ASSOC);

            return $itemsList;
        }

        /**
         * {@inheritDoc}
         */
        public function add(array $data = []):void {
            $connection = $this->connectToDB();

            $query      = (new InsertQueryBuilder($this->getTableName()))
                          ->set($data)
                          ->build();

            $connection->query($query->getQueryString());
        }

        /**
         * {@inheritDoc}
         */
        public function edit(array $data = []):void {
            $connection = $this->connectToDB();

            $query      = (new UpdateQueryBuilder($this->getTableName()))
                            ->set($data)
                            ->whereAnd("`" . $this->getDomainName() . "_id` = " . $data["id"])
                            ->build();

            $connection->query($query->getQueryString());
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            $connection = $this->connectToDB();
            $domainName = $this->getDomainName();

            $query      = (new UpdateQueryBuilder($this->getTableName()))
                          ->set([$domainName . "_is_deleted" => 1])
                          ->whereAnd("`{$domainName}_id` = " . $id)
                          ->build();

            $connection->query($query->getQueryString());
        }

        /**
         * Returns the Database connection
         *
         * @return mysqli
         */
        protected function connectToDB():mysqli {
            return DBConnectionProvider::getConnection(IDBConnection::class);
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