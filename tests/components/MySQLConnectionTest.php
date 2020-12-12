<?php

    namespace Tests\Components;

    use Components\MySQLConnection;
    use DBQueries\Query;
use DBQueries\SelectQueryBuilder;
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
         * Contains tested class object
         *
         * @var MySQLConnection
         */
        protected $connection;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->connection = new MySQLConnection();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->connection = null;
        }
        
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

            $this->assertInstanceOf(mysqli::class, $establishConnection->invokeArgs($this->connection, [[
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

            $this->assertInstanceOf(mysqli::class, $establishConnection->invokeArgs($this->connection, [[
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

            $this->assertNull($this->connection->fail(new mysqli_sql_exception()));
        }

        /**
         * @covers ::query
         *
         * @return void
         */
        public function testQueryCallsMySQLiQueryMethod():void {
            $mySQLConnectionReflection = new ReflectionClass($this->connection);
            $connection                = $mySQLConnectionReflection->getProperty("connection");
            
            $connection->setAccessible(true);

            $mysqliMock   = $this->getMockBuilder(mysqli::class)
                                    ->onlyMethods(["query"])
                                    ->getMock();
            $queryMock    = $this->getMockBuilder(Query::class)
                                    ->disableOriginalConstructor()
                                    ->onlyMethods(["getQueryString"])
                                    ->getMock();
            $mysqliResult = $this->getMockBuilder(mysqli_result::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();

            $mysqliMock->expects($this->once())
                        ->method("query")
                        ->willReturn($mysqliResult);

            $queryMock->method("getQueryString")
                        ->will($this->returnValue("SELECT * FROM `addresses`;"));

            $connection->setValue($this->connection, $mysqliMock);

            $this->connection->query($queryMock);
        }

        /**
         * @covers ::fetchAll
         *
         * @return void
         */
        public function testFetchAllReturnsArrayOfAssocArrays():void {
            $mySQLConnectionReflection = new ReflectionClass($this->connection);
            $connection                = $mySQLConnectionReflection->getProperty("connection");
            
            $connection->setAccessible(true);

            $mysqliMock = $this->getMockBuilder(mysqli::class)
                                    ->onlyMethods(["query"])
                                    ->getMock();
            $queryMock  = $this->getMockBuilder(Query::class)
                                    ->disableOriginalConstructor()
                                    ->onlyMethods(["getQueryString"])
                                    ->getMock();
            $resultMock = $this->getMockBuilder(mysqli_result::class)
                                    ->disableOriginalConstructor()
                                    ->onlyMethods(["fetch_all"])
                                    ->getMock();

            $mysqliMock->expects($this->once())
                        ->method("query")
                        ->willReturn($resultMock);

            $assocArr = [
                [
                    "id"   => "1",
                    "name" => "Moscow"
                ],
                [
                    "id"   => "2",
                    "name" => "Saint-Petersburg"
                ],
                [
                    "id"   => "3",
                    "name" => "Kazan"
                ]
            ];

            $resultMock->expects($this->once())
                        ->method("fetch_all")
                        ->will($this->returnValue($assocArr));

            $queryMock->method("getQueryString")
                        ->will($this->returnValue("SELECT * FROM `addresses`;"));

            $connection->setValue($this->connection, $mysqliMock);

            $this->assertEquals($assocArr, $this->connection->fetchAll($queryMock));
        }

    }