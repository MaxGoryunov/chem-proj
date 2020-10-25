<?php

    namespace Tests\Components;

    use Components\MySQLConnection;
use mysqli;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

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
        // protected $mySQLConnection;

        /**
         * Creates tested class object
         *
         * @return void
         */
        // protected function setUp():void {
        //     $this->mySQLConnection = new MySQLConnection();
        // }

        /**
         * Removes tested class object
         *
         * @return void
         */
        // protected function tearDown():void {
        //     $this->mySQLConnection = null;
        // }

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

    }