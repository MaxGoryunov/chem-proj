<?php

    namespace Tests\DBQueries;

    use DBQueries\DropTableQueryBuilder;
    use DBQueries\Query;
use Models\AbstractModel;
use PHPUnit\Framework\TestCase;

    /**
     * Testing DropTableQueryBuilder class
     * 
     * @coversDefaultClass Components\DropTableQueryBuilder
     */
    class DropTableQueryBuilderTest extends TestCase {

        /**
         * @covers ::build
         * 
         * @small
         *
         * @return void
         */
        public function testBuildBuildsCorrectQueryObject():void {
            $model = $this->getMockBuilder(AbstractModel::class)
                            ->setConstructorArgs(["addresses"])
                            ->getMock();

            $query = (new DropTableQueryBuilder($model))
                        ->build();
            
            $this->assertInstanceOf(Query::class, $query);

            $this->assertEquals("DROP TABLE IF EXISTS `addresses`;", $query->getQueryString());
        }
    }