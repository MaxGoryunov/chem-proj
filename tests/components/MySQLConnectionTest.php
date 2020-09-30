<?php

    namespace Tests\Components;

    use Components\MySQLConnection;
    use PHPUnit\Framework\TestCase;

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
        protected $mySQLConnection;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->mySQLConnection = new MySQLConnection();
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
         * @covers ::__construct
         *
         * @return MySQLConnection
         */
        public function testClassHasOnlyOneInstance():MySQLConnection {
            $instance = new MySQLConnection();

            $this->assertNotSame($instance, $this->mySQLConnection);

            return $instance;
        }

        /**
         * @covers ::getConnection
         *
         * @return void
         */
        public function testClassReturnsSameMySQLConnectionOnEachCall():void {
            $connection1 = $this->mySQLConnection->getConnection();
            $connection2 = $this->mySQLConnection->getConnection();

            $this->assertSame($connection1, $connection2);
        }

        /**
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