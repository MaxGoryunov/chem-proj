<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use DataMappers\AbstractDataMapper;
    use DBQueries\InsertQueryBuilder;
    use DBQueries\SelectQueryBuilder;
    use DBQueries\UpdateQueryBuilder;
    use Entities\IEntity;
    use Factories\AbstractMVCPDMFactory;
    use mysqli;
    use Traits\TableNameTrait;

    /**
     * Base class for implementing other Models
     */
    abstract class AbstractModel implements IModel {

        use TableNameTrait;

        /**
         * Pairings between table and domain names
         * 
         * @todo This is a temporary solution; should be replaced later
         * 
         * @var string[]
         */
        private const TABLES = [
            "addresses"     => "address",
            "genders"       => "gender",
            "user_statuses" => "user status"
        ];

        /**
         * Table which the model represents
         *
         * @var string
         */
        private $tableName;
        
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
        public function __construct(string $tableName, AbstractMVCPDMFactory $relatedFactory = null) {
            $this->tableName      = $tableName;
            $this->relatedFactory = $relatedFactory;
        }

        /**
         * Returns domain name in singular
         *
         * @return string
         */
        protected function getDomainName():string {
            return self::TABLES[$this->tableName];
        }

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
         * Returns the Database connection
         *
         * @return mysqli
         */
        protected function connectToDB():mysqli {
            return DBConnectionProvider::getConnection(IDBConnection::class);
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
        public function getById(int $id):IEntity {
            $builder = (new SelectQueryBuilder($this->getTableName()))
                        ->whereAnd("`" . $this->getDomainName() . "_is_deleted` = 0")
                        ->whereAnd("`" . $this->getDomainName() . "_id` = " . $id);

            $entity = $this->getDataMapper()->mapQueryResultToEntity($builder);

            return $entity;
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
         * Returns number of rows in a table
         *
         * @return int
         */
        public function calculateRecordCount():int {
            $connection = $this->connectToDB();
            $columns    = ["count" => "count(*)"];

            $query      = (new SelectQueryBuilder($this->getTableName()))
                            ->what($columns)
                            ->build();

			$result = $connection->query($query->getQueryString());
            $count  = $result->fetch_assoc()["count"];
            
			return $count;
        }

        /**
         * Returns the number of the current page
         *
         * @param string $requestUri
         * @return int
         */
        public function getCurrentPageNumber(string $requestUri):int {
			$uriParted  = explode('/', $requestUri);
			$pageString = $uriParted[count($uriParted) - 1];
			$pageParted = explode('=', $pageString);
            $pageNumber = $pageParted[1] ?? 1;
            
			return $pageNumber;
        }
    }