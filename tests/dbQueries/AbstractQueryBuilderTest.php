<?php

    namespace Tests\DBQueries;
    
    use DBQueries\AbstractQueryBuilder;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing AbstractQueryBuilder
     * 
     * @coversDefaultClass DBQueries\AbstractQueryBuilder
     */
    class AbstractQueryBuilderTest extends TestCase {
        
        /**
         * Contains tested class mock
         *
         * @var \PHPUnit\Framework\MockObject\MockObject|AbstractQueryBuilder
         */
        protected $builder;

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
            $this->builder = $this->getMockForAbstractClass(AbstractQueryBuilder::class, [$tableName]);

            $this->assertEquals($tableName, $this->builder->getTableName());
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