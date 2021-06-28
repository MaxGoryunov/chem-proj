<?php

    namespace Tests\Components;

    use Components\DBServiceProvider;
    use Components\IDBConnection;
    use PHPUnit\Framework\TestCase;

    include_once("./config/constants.php");

    /**
     * @@coversDefaultClass Components\DBServiceProvider
     */
    class DBServiceProviderTest extends TestCase {
        
        /**
         * Contains tested class string
         *
         * @var DBServiceProvider
         */
        protected $provider;

        /**
         * Creates tested class string
         *
         * @return void
         */
        protected function setUp():void {
            $this->provider = new DBServiceProvider();
        }

        /**
         * Removes tested class string
         *
         * @return void
         */
        protected function tearDown():void {
            $this->provider = null;
        }

        /**
         * @covers ::getConnection
         * 
         * @uses Components\IDBConnection
         * @uses Components\MySQLConnection
         * 
         * @small
         * 
         * @return void
         */
        public function testClassProvidesConnection():void {
            $this->assertInstanceOf(IDBConnection::class, $this->provider->getConnection());
        }
    }