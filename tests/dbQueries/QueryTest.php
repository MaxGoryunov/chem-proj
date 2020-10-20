<?php

    namespace Tests\DBQueries;

    use DBQueries\AbstractQueryBuilder;
    use DBQueries\Query;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing Query class
     * 
     * @coversDefaultClass \DBQueries\Query
     */
    class QueryTest extends TestCase {

        /**
         * @covers ::getQueryString
         * 
         * @dataProvider provideQueryStrings
         *
         * @param string $queryString
         * @return void
         */
        public function testClassReturnsSuppliedQueryString(string $queryString):void {
            /**
             * Mock for AbstractQueryBuilder class
             * 
             * @var \PHPUnit\Framework\MockObject\MockObject|AbstractQueryBuilder
             */
            $queryBuilder = $this->getMockBuilder(AbstractQueryBuilder::class)
                            ->onlyMethods(["build"])
                            ->disableOriginalConstructor()
                            ->getMock();

            $queryBuilder->expects($this->once())
                        ->method("build")
                        ->will($this->returnValue(new Query($queryString)));

            $query = $queryBuilder->build();

            $this->assertSame($queryString, $query->getQueryString());
    
        }

        /**
         * Provides query strings for Query class
         *
         * @return string[][]
         */
        public function provideQueryStrings():array {
            return [
                "none"   => [""],
                "select" => ["
                            SELECT `address_name` 
                            FROM `addresses`
                            WHERE `address_id` = 1;
                "],
                "update" => ["
                            UPDATE `addresses`
                            SET `address_name` = 'Moscow'
                            WHERE `address_id` = 2;
                "],
                "insert" => ["
                            INSERT INTO `addresses`
                            SET `address_name` = 'Kremlin';
                "],
                "delete" => ["
                            DELETE FROM `addresses`
                            WHERE `address_id` = 3;
                "]
            ];
        }
    }