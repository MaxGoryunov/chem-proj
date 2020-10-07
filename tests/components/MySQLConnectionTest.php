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

    }