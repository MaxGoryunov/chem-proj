<?php

    namespace Tests\Components;

    use Components\MySQLConnection;
    use PHPUnit\Framework\TestCase;

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
        protected $mySQLConnection;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->mySQLConnection = MySQLConnection::getInstance();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->mySQLConnection = null;
        }

        /**
         * @covers ::getInstance
         *
         * @return void
         */
        public function testInstanceIsOfMySQLConnectionClass():void {
            $this->assertInstanceOf(MySQLConnection::class, $this->mySQLConnection);
        
        }

        /**
         * @covers ::getInstance
         *
         * @return MySQLConnection
         */
        public function testClassHasOnlyOneInstance():MySQLConnection {
            $instance = MySQLConnection::getInstance();

            $this->assertSame($instance, $this->mySQLConnection);

            return $instance;
        }

        /**
         * @covers ::getConnection
         * @covers ::getInstance
         *
         * @return void
         */
        public function testClassReturnsSameMySQLConnectionOnEachCall():void {
            $connection1 = $this->mySQLConnection->getConnection();
            $connection2 = $this->mySQLConnection->getConnection();

            $this->assertSame($connection1, $connection2);
        }

        /**
         * @covers ::getInstance
         * @covers ::getConnection
         * 
         * @depends testClassHasOnlyOneInstance
         *
         * @param MySQLConnection $instance
         * @return void
         */
        public function testDifferentClassInstancesReturnsSameMySQLConnectionsOnEachCall(MySQLConnection $instance):void {
            $connection1 = $instance->getConnection();
            $connection2 = $this->mySQLConnection->getConnection();

            $this->assertSame($connection1, $connection2);
        }

    }