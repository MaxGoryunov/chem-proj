<?php

    namespace Tests\DBQueries;

use DBQueries\UpdateQueryBuilder;
use PHPUnit\Framework\TestCase;

    /**
     * Testing UpdateQueryBuilder
     * 
     * @coversDefaultClass UpdateQueryBuilder
     */
    class UpdateQueryBuilderTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var UpdateQueryBuilder
         */
        protected $updateBuilder;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->updateBuilder = new UpdateQueryBuilder("medicines");
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->updateBuilder = null;
        }

        /**
         * @covers ::build
         *
         * @return void
         */
        public function testBuildBuildsCorrectStatement():void {
            $query = $this->updateBuilder->set([
                "medicine_name"  => "Sensu Bean",
                "medicine_price" => 760,
                "medicine_doze"  => 50
            ])
                                         ->whereAnd("`medicine_id` = 1")
                                         ->whereOr("`medicine_id` = 3")
                                         ->limit(4)
                                         ->build();

            $this->assertEquals(" UPDATE `medicines` SET `medicine_name` = 'Sensu Bean', `medicine_price` = '760', `medicine_doze` = '50' WHERE 1 AND `medicine_id` = 1 OR `medicine_id` = 3 LIMIT 4; ", preg_replace("/\s+/", " ", preg_replace("/\n/", " ", $query->getQueryString())));

        }
    }