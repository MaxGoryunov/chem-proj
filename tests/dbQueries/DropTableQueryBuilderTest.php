<?php

    namespace Tests\DBQueries;

    use DBQueries\DropTableQueryBuilder;
    use DBQueries\Query;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing DropTableQueryBuilder class
     * 
     * @coversDefaultClass DropTableQueryBuilder
     */
    class DropTableQueryBuilderTest extends TestCase {

        /**
         * @covers ::build
         *
         * @return void
         */
        public function testBuildBuildsCorrectQueryObject():void {
            $query = (new DropTableQueryBuilder("addresses"))
                        ->build();
            
            $this->assertInstanceOf(Query::class, $query);

            $this->assertEquals("DROP TABLE IF EXISTS `addresses`;", $query->getQueryString());
        }
    }