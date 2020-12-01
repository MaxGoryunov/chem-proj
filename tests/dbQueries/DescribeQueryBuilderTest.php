<?php

    namespace Tests\DBQueries;

    use DBQueries\DescribeQueryBuilder;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing DescribeQueryBuilder class
     * 
     * @coversDefaultClass DescribeQueryBuilder
     */
    class DescribeQueryBuilderTest extends TestCase {

        /**
         * @covers ::build
         * 
         * @dataProvider provideTableNames
         *
         * @param string $tableName
         * @return void
         */
        public function testBuildBuildsCorrectQueryObject(string $tableName):void {
            $query = (new DescribeQueryBuilder($tableName))
                        ->build();

            $this->assertEquals("DESCRIBE `$tableName`;", preg_replace("/\s+/", " ", preg_replace("/\n/", " ", $query->getQueryString())));
        }

        /**
         * @return string[][]
         */
        public function provideTableNames():array {
            return [
                "addresses" => ["addresses"],
                "chemicals" => ["chemicals"],
                "companies" => ["companies"]
            ];
        }
    }