<?php

    namespace Tests\DBQueries;
    
    use DBQueries\AbstractQueryBuilder;
use DBQueries\IQuery;
use Models\AbstractModel;
use PHPUnit\Framework\TestCase;

    /**
     * Testing AbstractQueryBuilder
     * 
     * @coversDefaultClass DBQueries\AbstractQueryBuilder
     */
    class AbstractQueryBuilderTest extends TestCase {

        /**
         * @covers ::__construct
         * @covers ::getTableName
         * 
         * @dataProvider provideTableNames
         *
         * @param string $tableName
         * @return void
         */
        public function testGetTableNameReturnsCorrectTable(string $tableName):void {
            $model = $this->getMockBuilder(AbstractModel::class)
                            ->setConstructorArgs([$tableName])
                            ->getMock();

            $builder = $this->getMockForAbstractClass(AbstractQueryBuilder::class, [$model]);

            $this->assertEquals($tableName, $builder->getTableName());
        }

        /**
         * @covers ::__construct
         * @covers ::build
         * 
         * @uses DBQueries\Query
         *
         * @return void
         */
        public function testBuildReturnsIQueryObject():void {
            $model = $this->getMockBuilder(AbstractModel::class)
                            ->setConstructorArgs(["addresses"])
                            ->getMock();

            $builder = $this->getMockForAbstractClass(AbstractQueryBuilder::class, [$model]);

            $this->assertInstanceOf(IQuery::class, $builder->build());
        }

        /**
         * Provides table names for testing
         *
         * @return string[][]
         */
        public function provideTableNames():array {
            return [
                ["medicines"],
                ["addresses"],
                [""]
            ];
        }
    }