<?php

    namespace Models;

    use Components\DBConnectionProvider;
    use DataMappers\AbstractDataMapper;
    use DBQueries\SelectQueryBuilder;
    use Factories\AbstractMVCPDMFactory;
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
        public function __construct(AbstractMVCPDMFactory $relatedFactory) {
            $this->relatedFactory = $relatedFactory;
        }

        protected function getDataMapper():AbstractDataMapper {
            if (!isset($this->relatedMapper)) {
                $this->relatedMapper = $this->relatedFactory->getDataMapper();
            }

            return $this->relatedMapper;
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