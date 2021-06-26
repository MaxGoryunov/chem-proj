<?php

    namespace Tests\DBQueries;
    
    use DBQueries\InsertQueryBuilder;
    use Models\AbstractModel;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing InsertQueryBuilder class
     * 
     * @coversDefaultClass \DBQueries\InsertQueryBuilder
     */
    class InsertQueryBuilderTest extends TestCase {
        
        /**
         * Contains tested class object
         *
         * @var InsertQueryBuilder
         */
        protected $insertBuilder;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $model = $this->getMockBuilder(AbstractModel::class)
                            ->setConstructorArgs(["medicines"])
                            ->getMock();

            $this->insertBuilder = new InsertQueryBuilder($model);
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->insertBuilder = null;
        }

        /**
         * @covers ::getQueryString
         * @covers ::build
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\Query
         * @uses Traits\SetTrait
         *
         * @return void
         */
        public function testBuildBuildsCorrectQueryObject():void {
            $query = $this->insertBuilder->set([
                                "medicine_name"  => "Sensu Bean",
                                "medicine_price" => 400,
                                "medicine_doze"  => 25,
                            ])
                          ->build();

            $this->assertEquals(preg_replace("/\n/", "", " INSERT INTO `medicines` SET `medicine_name` = 'Sensu Bean', `medicine_price` = '400', `medicine_doze` = '25'; "), preg_replace("/\s+/", " ", preg_replace("/\n/", " ", $query->getQueryString())));
        }
    }