<?php

    use DBQueries\InsertQueryBuilder;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing InsertQueryBuilder class
     * 
     * @coversDefaultClass InsertQueryBuilder
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
            $this->insertBuilder = new InsertQueryBuilder("medicines");
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->insertBuilder = null;
        }

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