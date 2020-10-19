<?php

    namespace Tests\Components;

    use Components\DBConnectionProvider;
    use Components\IDBConnection;
    use Components\MySQLConnection;
    use InvalidArgumentException;
    use PHPUnit\Framework\TestCase;

    include_once("./config/constants.php");

    /**
     * Testing TDBConnectionProvider class
     * 
     * @@coversDefaultClass DBConnectionProvider
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
         * @return void
         */
        public function testClassProvidesConnection():void {
            $this->assertInstanceOf(MySQLConnection::class, $this->connectionProvider::getConnection(IDBConnection::class));
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