<?php

    namespace Tests\DBQueries;

    use DBQueries\DropTableQueryBuilder;
    use DBQueries\Query;
use Models\AbstractModel;
use Models\IModel;
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
            $model = $this->getMockBuilder(IModel::class)
                            ->disableOriginalConstructor()
                            ->getMock();

            $model->method("getTableName")
                    ->willReturn("addresses");

            $query = (new DropTableQueryBuilder($model))
                        ->build();
            
            $this->assertInstanceOf(Query::class, $query);

            $this->assertEquals("DROP TABLE IF EXISTS `addresses`;", $query->getQueryString());
        }
    }