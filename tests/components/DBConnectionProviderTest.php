<?php

    namespace Tests\Components;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use InvalidArgumentException;
    use mysqli;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing TDBConnectionProvider class
     * 
     * @@coversDefaultClass Components\DBConnectionProvider
     */
    class DBConnectionProviderTest extends TestCase {
        
        /**
         * Contains tested class string
         *
         * @var string
         */
        protected $connectionProvider;

        /**
         * Creates tested class string
         *
         * @return void
         */
        protected function setUp():void {
            $this->connectionProvider = DBConnectionProvider::class;
        }

        /**
         * Removes tested class string
         *
         * @return void
         */
        protected function tearDown():void {
            $this->connectionProvider = null;
        }

        /**
         * @covers ::getConnection
         * 
         * @uses Components\MySQLConnection::getInstance
         * @uses Components\MySQLConnection::getConnection
         * @uses Components\MySQLConnection::__construct
         * 
         * @return void
         */
        public function testClassProvidesConnection():void {
            $this->assertInstanceOf(mysqli::class, $this->connectionProvider::getConnection(IDBConnection::class));
        }

        /**
         * @covers ::getConnection
         * 
         * @uses Components\MySQLConnection::getInstance
         * @uses Components\MySQLConnection::getConnection
         * @uses Components\MySQLConnection::__construct
         *
         * @return void
         */
        public function testClassProvidesSameConnectionOnEachCall():void {
            $connection1 = $this->connectionProvider::getConnection(IDBConnection::class);
            $connection2 = $this->connectionProvider::getConnection(IDBConnection::class);

            $this->assertSame($connection1, $connection2);
        }

        /**
         * @covers ::getConnection
         * 
         * @dataProvider provideBadArguments
         *
         * @return void
         */
        public function testClassThrowsExceptionOnCallWithUnknownArgument(string $connectionType):void {
            $this->expectException(InvalidArgumentException::class);

            $connection = $this->connectionProvider::getConnection($connectionType);
        }

        /**
         * Provides bad arguments for getConnection() call
         *
         * @return string[][]
         */
        public function provideBadArguments():array {
            return [
                "none"               => [""],
                "concreteConnection" => [MySQLConnection::class],
                "self"               => [DBConnectionProvider::class]
            ];
        }

    }