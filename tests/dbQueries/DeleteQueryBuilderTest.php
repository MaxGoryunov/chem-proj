<?php

    namespace Tests\DBQueries;

    use DBQueries\DeleteQueryBuilder;
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
            $this->deleteBuilder = new DeleteQueryBuilder("medicines");
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
            $query = $this->deleteBuilder->whereAnd("`medicine_price` < 300")
                                         ->whereOr("`medicine_price` > 500")
                                         ->limit(3)
                                         ->build();

            $this->assertEquals(" DELETE FROM `medicines` WHERE 1 AND `medicine_price` < 300 OR `medicine_price` > 500 LIMIT 3; ", preg_replace("/\s+/", " ", preg_replace("/\n/", " ", $query->getQueryString())));
        }
    }