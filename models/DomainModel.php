<?php

    namespace Models;

use Components\DBServiceProvider;
use Components\IDBConnection;
    use DataMappers\DataMapper;
use DataMappers\DomainMapper;
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
    class DomainModel implements IModel {

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
         * {@inheritDoc}
         */
        public function getTableName(): string
        {
            return $this->tableName;
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
        protected function getDataMapper():DomainMapper {
            $this->relatedMapper ??= $this->relatedFactory->getDataMapper();

            return $this->relatedMapper;
        }

        /**
         * Returns the Database connection
         *
         * @return IDBConnection
         */
        protected function connectToDB():IDBConnection {
            return (new DBServiceProvider())->getConnection();
        }

        /**
         * {@inheritDoc}
         */
        public function getList(int $limit, string $uri):array {
            return $this->connectToDB()->query(
                (new SelectQueryBuilder($this))
                ->where("`" . $this->getDomainName() . "_is_deleted` = 0")
                ->limit(
                    $limit,
                    $limit * ($this->getCurrentPageNumber($uri) - 1)
                )
            )->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * {@inheritDoc}
         */
        public function getById(int $id):IEntity {
            return $this->getDataMapper()->mapQueryResultToEntity(
                (new SelectQueryBuilder($this))
                ->where("`" . $this->getDomainName() . "_is_deleted` = 0")
                ->and("`" . $this->getDomainName() . "_id` = " . $id)
            );
        }

        /**
         * {@inheritDoc}
         */
        public function add(array $data = []):void {
            if ($data !== []) {
                $this->connectToDB()->query(
                    (new InsertQueryBuilder($this))
                    ->set($data)
                );
            }
        }

        /**
         * {@inheritDoc}
         */
        public function edit(array $data = [], int $id):void {
            if ($data !== []) {
                $this->connectToDB()->query(
                    (new UpdateQueryBuilder($this))
                    ->set($data)
                    ->where("`" . $this->getDomainName() . "_id` = " . $id)
                );
            }
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            $domainName = $this->getDomainName();

            $this->connectToDB()->query(
                (new UpdateQueryBuilder($this))
                ->set([$domainName . "_is_deleted" => 1])
                ->where("`{$domainName}_id` = " . $id)
            );
        }

        /**
         * Returns number of rows in a table
         *
         * @return int
         */
        public function calculateRecordCount():int {
			return $this->connectToDB()->query(
                (new SelectQueryBuilder($this))
                ->what(["count" => "count(*)"])
            )->fetch_assoc()["count"];
        }

        /**
         * Returns the number of the current page
         *
         * @param string $requestUri
         * @return int
         */
        public function getCurrentPageNumber(string $requestUri):int {
			$uriParted  = explode("/", $requestUri);
            
			return explode(
                "=",
                $uriParted[count($uriParted) - 1]
            ) ?? 1;
        }

        /**
         * Determines if the supplied params exist or not
         *
         * @param array<string, mixed>  $params - params to check
         * @param string[]              $list   - list of required params
         * @return bool
         */
        public function paramsExist(array $params, array $list):bool {
            foreach ($list as $name) {
                if (!isset($params[$name])) {
                    return false;
                }
            }

            return true;
        }

        /**
         * Fills data output or leaves it empty if some parameters are missing
         *
         * @param array $source from which the elements are extracted
         * @param array $list   list of parameters to be resent
         * @return array
         */
        public function filledOrEmpty(array $source, array $list): array {
            $filled = [];
            foreach ($list as $param) {
                if (isset($source[$param])) {
                    $filled[$param] = $source[$param];
                } else {
                    $filled = [];
                    break;
                }
            }

            return $filled;
        }
    }