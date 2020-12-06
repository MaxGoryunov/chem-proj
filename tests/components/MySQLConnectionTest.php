<?php

    namespace Tests\Components;

    use Components\MySQLConnection;
    use DBQueries\Query;
    use mysqli;
    use mysqli_result;
use mysqli_sql_exception;
use PHPUnit\Framework\TestCase;
    use ReflectionClass;
use ReflectionMethod;

/**
     * Testing MySQLConnection class
     * 
     * @coversDefaultClass MySQLConnection
     */
    class MySQLConnectionTest extends TestCase {

        /**
         * Returns the protected or private tested class method
         *
         * @param string $methodName
         * @return ReflectionMethod
         */
        protected function getInnerMethod(string $methodName):ReflectionMethod {
            $reflection = new ReflectionClass(MySQLConnection::class);
            $method     = $reflection->getMethod($methodName);

            $method->setAccessible(true);

            return $method;
        }

        /**
         * @covers ::establishConnection
         * @covers ::validateConnection
         *
         * @return void
         */
        public function testEstablishConnectionSetsUpCorrectMySQLiObject():void {
            $establishConnection = $this->getInnerMethod("establishConnection");

            $this->assertInstanceOf(mysqli::class, $establishConnection->invokeArgs(new MySQLConnection(), [[
                "host"     => "localhost",
                "user"     => "root",
                "password" => "",
                "database" => "chemistry",
                "charset"  => "utf8"
            ]]));
        }

        /**
         * @covers ::establishConnection
         *
         * @return void
         */
        public function testEstablishConnectionThrowsExceptionOnMySQLiError():void {
            $this->expectException(mysqli_sql_exception::class);

            $establishConnection = $this->getInnerMethod("establishConnection");

            $this->assertInstanceOf(mysqli::class, $establishConnection->invokeArgs(new MySQLConnection(), [[
                "host"     => "aaaaa",
                "user"     => "root",
                "password" => "",
                "database" => "chemistry",
                "charset"  => "utf8"
            ]]));
        }

        /**
         * @covers ::fail
         *
         * @return void
         */
        public function testFailThrowsException():void {
            $this->expectException(mysqli_sql_exception::class);

            $connection = new MySQLConnection();

            $this->assertNull($connection->fail(new mysqli_sql_exception()));
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