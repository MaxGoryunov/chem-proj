<?php

    namespace Tests\Components;

    use Components\Autoloader;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing Autoloader class
     * 
     * @coversDefaultClass Autoloader
     */
    class AutoloaderTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var Autoloader
         */
        protected $autoloader;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->autoloader = new Autoloader();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->autoloader = null;
        }

        /**
         * @covers ::register
         * @covers ::getAutoloaders
         *
         * @return void
         */
        public function testRegisterMethodRegistersDefaultFunction():void {
            $this->autoloader->register();

            $this->assertContains("spl_autoload", $this->autoloader->getAutoloaders());
        }

        

    }