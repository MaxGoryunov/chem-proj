<?php

    namespace Tests\Components;

    use Components\MySQLConnection;
use DBQueries\Query;
use mysqli;
use mysqli_result;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
     * Testing MySQLConnection class
     * 
     * @coversDefaultClass MySQLConnection
     */
    class MySQLConnectionTest extends TestCase {

        /**
         * @covers ::establishConnection
         * @covers ::validateConnection
         *
         * @return void
         */
        public function testEstablishConnectionSetsUpCorrectMySQLiObject():void {
            $mySQLConnectionReflection = new ReflectionClass(MySQLConnection::class);
            $establishConnection       = $mySQLConnectionReflection->getMethod("establishConnection");

            $establishConnection->setAccessible(true);

            $this->assertInstanceOf(mysqli::class, $establishConnection->invokeArgs(new MySQLConnection(), [[
                "host"     => "localhost",
                "user"     => "root",
                "password" => "",
                "database" => "chemistry",
                "charset"  => "utf8"
            ]]));
        }

        /**
         * @covers ::query
         *
         * @return void
         */
        public function testQueryCallsMySQLiQueryMethod():void {
            $mySQLConnectionReflection = new ReflectionClass(MySQLConnection::class);
            $connection                = $mySQLConnectionReflection->getProperty("connection");
            
            $connection->setAccessible(true);

            $mySQLConnection = new MySQLConnection();
            $mysqliMock      = $this->getMockBuilder(mysqli::class)
                                    ->onlyMethods(["query"])
                                    ->getMock();
            $queryMock       = $this->getMockBuilder(Query::class)
                                    ->disableOriginalConstructor()
                                    ->onlyMethods(["getQueryString"])
                                    ->getMock();
            $mysqliResult    = $this->getMockBuilder(mysqli_result::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();

            $mysqliMock->expects($this->once())
                        ->method("query")
                        ->willReturn($mysqliResult);

            $queryMock->method("getQueryString")
                        ->will($this->returnValue("SELECT * FROM `addresses`;"));

            $connection->setValue($mySQLConnection, $mysqliMock);

            $mySQLConnection->query($queryMock);
        }

    }