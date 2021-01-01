<?php

    namespace Tests\Components;

    use Components\MySQLConnection;
    use DBQueries\IQueryBuilder;
    use DBQueries\Query;
    use Entities\IEntity;
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
            $builder      = $this->getMockBuilder(IQueryBuilder::class)
                                    ->disableOriginalConstructor()
                                    ->onlyMethods(["build"])
                                    ->getMock();

            $mysqliMock->expects($this->once())
                        ->method("query")
                        ->willReturn($mysqliResult);

            $queryMock->method("getQueryString")
                        ->will($this->returnValue("SELECT * FROM `addresses`;"));

            $builder->expects($this->once())
                    ->method("build")
                    ->will($this->returnValue($queryMock));

            $connection->setValue($this->connection, $mysqliMock);

            $this->connection->query($builder);
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
            $builder    = $this->getMockBuilder(IQueryBuilder::class)
                                    ->disableOriginalConstructor()
                                    ->onlyMethods(["build"])
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

            $builder->expects($this->once())
                    ->method("build")
                    ->will($this->returnValue($queryMock));

            $connection->setValue($this->connection, $mysqliMock);

            $this->assertEquals($assocArr, $this->connection->fetchAll($builder));
        }

        /**
         * @covers ::fetchAssoc
         *
         * @return void
         */
        public function testFetchAllReturnsResultArray():void {
            $reflection = new ReflectionClass($this->connection);
            $connection = $reflection->getProperty("connection");

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
                            ->onlyMethods(["fetch_assoc"])
                            ->getMock();

            $builder    = $this->getMockBuilder(IQueryBuilder::class)
                            ->disableOriginalConstructor()
                            ->onlyMethods(["build"])
                            ->getMock();

            $mysqliMock->expects($this->exactly(2))
                        ->method("query")
                        ->will($this->returnValue($resultMock));

            $userInfo = [
                "id"      => "12",
                "name"    => "John",
                "surname" => "Doe"
            ];

            $resultMock->expects($this->exactly(2))
                        ->method("fetch_assoc")
                        ->will($this->returnValue($userInfo));

            $queryMock->expects($this->exactly(2))
                        ->method("getQueryString")
                        ->will($this->returnValue("SELECT * FROM `users` WHERE `user_id` = 12;"));

            $builder->expects($this->exactly(2))
                    ->method("build")
                    ->will($this->returnValue($queryMock));

            $connection->setValue($this->connection, $mysqliMock);

            $this->assertEquals($userInfo, $this->connection->fetchAssoc($builder));

            $this->assertEquals($userInfo["id"], $this->connection->fetchAssoc($builder, "id"));
        }

        /**
         * @covers ::fetchObject
         *
         * @return void
         */
        public function testFetchObjectReturnsResultObject():void {
            $reflection = new ReflectionClass($this->connection);
            $connection = $reflection->getProperty("connection");

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
                                ->onlyMethods(["fetch_object"])
                                ->getMock();

            $builder    = $this->getMockBuilder(IQueryBuilder::class)
                                ->disableOriginalConstructor()
                                ->onlyMethods(["build"])
                                ->getMock();

            $entity     = $this->getMockBuilder(IEntity::class)
                                ->getMock();

            $mysqliMock->expects($this->once())
                        ->method("query")
                        ->willReturn($resultMock);

            $resultMock->expects($this->once())
                        ->method("fetch_object")
                        ->willReturn($entity);

            $queryMock->expects($this->once())
                        ->method("getQueryString")
                        ->willReturn("SELECT * FROM `addresses` WHERE `address_id` = 12;");

            $builder->expects($this->once())
                    ->method("build")
                    ->willReturn($queryMock);

            $connection->setValue($this->connection, $mysqliMock);

            $this->assertInstanceOf(IEntity::class, $this->connection->fetchObject($builder, IEntity::class));

        }
    }