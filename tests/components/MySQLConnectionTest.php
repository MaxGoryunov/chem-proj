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
     * @coversDefaultClass Components\MySQLConnection
     */
    class MySQLConnectionTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var MySQLConnection
         */
        protected $connection;

        /**
         * Contains object helping for testing
         * 
         * Mocks Query object
         *
         * @var \PHPUnit\Framework\MockObject\MockObject|Query
         */
        protected $queryMock;

        /**
         * Contains object helping for testing
         * 
         * Mocks builder object
         *
         * @var \PHPUnit\Framework\MockObject\MockObject|IQueryBuilder
         */
        protected $builder;

        /**
         * COntains object helping for testing
         * 
         * Mocks mysqli_result object
         *
         * @var \PHPUnit\Framework\MockObject\MockObject|mysqli_result
         */
        protected $resultMock;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->connection          = new MySQLConnection();
            $mySQLConnectionReflection = new ReflectionClass($this->connection);
            $connectionReflection      = $mySQLConnectionReflection->getProperty("connection");

            $connectionReflection->setAccessible(true);

            $mysqliMock       = $this->getMockBuilder(mysqli::class)
                                    ->onlyMethods(["query"])
                                    ->getMock();

            $this->queryMock  = $this->getMockBuilder(Query::class)
                                    ->disableOriginalConstructor()
                                    ->onlyMethods(["getQueryString"])
                                    ->getMock();

            $this->resultMock = $this->getMockBuilder(mysqli_result::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();

            $this->builder    = $this->getMockBuilder(IQueryBuilder::class)
                                    ->disableOriginalConstructor()
                                    ->onlyMethods(["build"])
                                    ->getMock();

            $mysqliMock->expects($this->any())
                        ->method("query")
                        ->willReturn($this->resultMock);

            $connectionReflection->setValue($this->connection, $mysqliMock);
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
         * @covers ::__construct
         * @covers ::establishConnection
         * 
         * @small
         *
         * @return void
         */
        public function testConstructInvokesEstablishConnectionIfTheConnectionIsNotSet():void {
            $reflection = new ReflectionClass($this->connection);
            $mysqli     = $reflection->getProperty("connection");

            $mysqli->setAccessible(true);
            $mysqli->setValue($this->connection, null);

            $connection = new MySQLConnection();

            $this->assertInstanceOf(mysqli::class, $mysqli->getValue($connection));
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
         * @covers ::__construct
         * @covers ::fail
         * @covers ::establishConnection
         * 
         * @small
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
         * @covers ::__construct
         * @covers ::fail
         * 
         *
         * @small
         * @return void
         */
        public function testFailThrowsException():void {
            $this->expectException(mysqli_sql_exception::class);

            $this->assertNull($this->connection->fail(new mysqli_sql_exception()));
        }

        /**
         * @covers ::__construct
         * @covers ::query
         * 
         * @small
         *
         * @return void
         */
        public function testQueryCallsMySQLiQueryMethod():void {
            $this->queryMock->method("getQueryString")
                        ->will($this->returnValue("SELECT * FROM `addresses`;"));

            $this->builder->expects($this->once())
                    ->method("build")
                    ->will($this->returnValue($this->queryMock));

            $this->connection->query($this->builder);
        }

        /**
         * @covers ::__construct
         * @covers ::query
         * @covers ::fetchAll
         * 
         * @small
         *
         * @return void
         */
        public function testFetchAllReturnsArrayOfAssocArrays():void {
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

            $this->resultMock->expects($this->once())
                        ->method("fetch_all")
                        ->will($this->returnValue($assocArr));

            $this->queryMock->method("getQueryString")
                        ->will($this->returnValue("SELECT * FROM `addresses`;"));

            $this->builder->expects($this->once())
                    ->method("build")
                    ->will($this->returnValue($this->queryMock));

            $this->assertEquals($assocArr, $this->connection->fetchAll($this->builder));
        }

        /**
         * @covers ::__construct
         * @covers ::establishConnection
         * @covers ::query
         * @covers ::fetchAssoc
         * 
         * @small
         *
         * @return void
         */
        public function testFetchAssocReturnsResultArray():void {
            $userInfo = [
                "id"      => "12",
                "name"    => "John",
                "surname" => "Doe"
            ];

            $this->resultMock->expects($this->exactly(2))
                        ->method("fetch_assoc")
                        ->will($this->returnValue($userInfo));

            $this->queryMock->expects($this->exactly(2))
                        ->method("getQueryString")
                        ->will($this->returnValue("SELECT * FROM `users` WHERE `user_id` = 12;"));

            $this->builder->expects($this->exactly(2))
                    ->method("build")
                    ->will($this->returnValue($this->queryMock));

            $this->assertEquals($userInfo, $this->connection->fetchAssoc($this->builder));
            $this->assertEquals($userInfo["id"], $this->connection->fetchAssoc($this->builder, "id"));
        }

        /**
         * @covers ::__construct
         * @covers ::query
         * @covers ::fetchObject
         * 
         * @small
         *
         * @return void
         */
        public function testFetchObjectReturnsResultObject():void {
            $entity = $this->getMockBuilder(IEntity::class)
                            ->getMock();

            $this->resultMock->expects($this->once())
                        ->method("fetch_object")
                        ->willReturn($entity);

            $this->queryMock->expects($this->once())
                        ->method("getQueryString")
                        ->willReturn("SELECT * FROM `addresses` WHERE `address_id` = 12;");

            $this->builder->expects($this->once())
                    ->method("build")
                    ->willReturn($this->queryMock);

            $this->assertInstanceOf(IEntity::class, $this->connection->fetchObject($this->builder, IEntity::class));
        }

        /**
         * @covers ::__construct
         * @covers ::query
         * @covers ::fetchObjects
         * 
         * @small
         *
         * @return void
         */
        public function testFetchObjectsReturnsResultObjects():void {
            $entity = $this->getMockBuilder(IEntity::class)
                                ->getMock();

            $this->resultMock->expects($this->exactly(4))
                        ->method("fetch_object")
                        ->will($this->onConsecutiveCalls($entity, $entity, $entity, null));

            $this->queryMock->expects($this->once())
                        ->method("getQueryString")
                        ->willReturn("SELECT * FROM `addresses`;");

            $this->builder->expects($this->once())
                    ->method("build")
                    ->willReturn($this->queryMock);

            $entities = $this->connection->fetchObjects($this->builder, IEntity::class);

            $this->assertInstanceOf(IEntity::class, $entities[0]);
            $this->assertEquals([$entity, $entity, $entity], $entities);
        }
    }