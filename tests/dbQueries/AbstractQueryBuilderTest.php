<?php

    namespace Tests\DBQueries;
    
    use DBQueries\AbstractQueryBuilder;
use DBQueries\IQuery;
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
            $builder = $this->getMockForAbstractClass(AbstractQueryBuilder::class, [$tableName]);

            $this->assertEquals($tableName, $builder->getTableName());
        }

        /**
         * @covers ::build
         *
         * @return void
         */
        public function testBuildReturnsIQueryObject():void {
            $builder = $this->getMockForAbstractClass(AbstractQueryBuilder::class, ["addresses"]);

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