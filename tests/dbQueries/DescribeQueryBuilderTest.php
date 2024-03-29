<?php

    namespace Tests\DBQueries;

    use DBQueries\DescribeQueryBuilder;
    use DBQueries\IQuery;
use Models\AbstractModel;
use Models\IModel;
use PHPUnit\Framework\TestCase;

    /**
     * Testing DescribeQueryBuilder class
     * 
     * @coversDefaultClass DBQueries\DescribeQueryBuilder
     */
    class DescribeQueryBuilderTest extends TestCase {

        /**
         * @covers ::build
         * @covers ::getQueryString
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\Query
         * 
         * @dataProvider provideTableNames
         * 
         * @small
         *
         * @param string $tableName
         * @return void
         */
        public function testBuildBuildsCorrectQueryObject(string $tableName):void {
            $model = $this->getMockBuilder(IModel::class)
                            ->disableOriginalConstructor()
                            ->getMock();

            $model->method("getTableName")
                    ->willReturn($tableName);

            $builder = new DescribeQueryBuilder($model);

            $this->assertInstanceOf(IQuery::class, $builder->build());

            $this->assertEquals("DESCRIBE `$tableName`;", preg_replace("/\s+/", " ", preg_replace("/\n/", " ", $builder->getQueryString())));
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