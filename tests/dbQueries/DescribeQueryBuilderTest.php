<?php

    namespace Tests\DBQueries;

    use DBQueries\DescribeQueryBuilder;
    use DBQueries\IQuery;
use Models\AbstractModel;
use PHPUnit\Framework\TestCase;

    /**
     * Testing DescribeQueryBuilder class
     * 
     * @coversDefaultClass Components\DescribeQueryBuilder
     */
    class DescribeQueryBuilderTest extends TestCase {

        /**
         * @covers ::build
         * 
         * @dataProvider provideTableNames
         * 
         * @small
         *
         * @param string $tableName
         * @return void
         */
        public function testBuildBuildsCorrectQueryObject(string $tableName):void {
            $model = $this->getMockBuilder(AbstractModel::class)
                            ->setConstructorArgs([$tableName])
                            ->getMock();

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