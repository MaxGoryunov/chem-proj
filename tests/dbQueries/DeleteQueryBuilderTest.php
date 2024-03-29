<?php

    namespace Tests\DBQueries;

    use DBQueries\DeleteQueryBuilder;
use Models\AbstractModel;
use Models\IModel;
use PHPUnit\Framework\TestCase;

    /**
     * Testing DeleteQueryBuilder
     * 
     * @coversDefaultClass \DBQueries\DeleteQueryBuilder
     */
    class DeleteQueryBuilderTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var DeleteQueryBuilder
         */
        protected $deleteBuilder;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $model = $this->getMockBuilder(IModel::class)
                            ->disableOriginalConstructor()
                            ->getMock();

            $model->method("getTableName")->willReturn("medicines");

            $this->deleteBuilder = new DeleteQueryBuilder($model);
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->deleteBuilder = null;
        }

        /**
         * @covers ::getQueryString
         * @covers ::build
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\Query
         * @uses Traits\WhereTrait
         * @uses Traits\LimitTrait
         *
         * @return void
         */
        public function testBuildBuildsCorrectQueryObject():void {
            $query = $this->deleteBuilder->where("`medicine_price` < 300")
                                         ->or("`medicine_price` > 500")
                                         ->limit(3)
                                         ->build();

            $this->assertEquals(" DELETE FROM `medicines` WHERE `medicine_price` < '300' OR `medicine_price` > '500' LIMIT 3; ", preg_replace("/\s+/", " ", preg_replace("/\n/", " ", $query->getQueryString())));
        }
    }