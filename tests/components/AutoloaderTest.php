<?php

    namespace Tests\Components;

    use Closure;
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
            foreach ($this->autoloader->getAutoloaders() as $key => $autoloader) {
                if ($key != 0) {
                    spl_autoload_unregister($autoloader);
                }
            }

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
            /**
             * Asserting 2 because of PHPUnit's autoloader
             */
            $this->assertCount(2, $this->autoloader->getAutoloaders());
        }

        /**
         * @covers ::register
         * @covers ::getAutoloaders
         * 
         * @dataProvider provideAutoloaderFunctions
         *
         * @param Closure $func
         * @return void
         */
        public function testRegisterMethodRegistersSuppliedFunction(Closure $func):void {
            $this->assertNotContains($func, $this->autoloader->getAutoloaders());

            $this->autoloader->register($func);

            $this->assertContains($func, $this->autoloader->getAutoloaders());
            $this->assertCount(2, $this->autoloader->getAutoloaders());
        }

        /**
         * @covers ::unregister
         * @covers ::getAutoloaders
         * 
         * @dataProvider provideAutoloaderFunctions
         *
         * @param Closure $func
         * @return void
         */
        public function testUnregisterMethodUnregistersSuppliedFunction(Closure $func):void {
            $this->testRegisterMethodRegistersSuppliedFunction($func);

            $this->autoloader->unregister($func);

            $this->assertNotContains($func, $this->autoloader->getAutoloaders());
        }


        /**
         * @covers ::unregister
         * @covers ::getAutoloaders
         * 
         * @depends testRegisterMethodRegistersDefaultFunction
         * 
         * @return void
         */
        public function testUnregisterMethodUnregistersDefaultFunction():void {
            $this->testRegisterMethodRegistersDefaultFunction();

            $this->autoloader->unregister();
            /**
             * Asserting 1 because of PHPUnit's autoloader
             */
            $this->assertNotContains("spl_autoload", $this->autoloader->getAutoloaders());
            $this->assertCount(1, $this->autoloader->getAutoloaders());
        }

        /**
         * Provides functions for 'register' method
         *
         * @return Closure[][]
         */
        public function provideAutoloaderFunctions():array {
            return [
                "include"            => [function (string $className) {
                    include_once("./$className.php");
                }],
                "require"            => [function (string $className) {
                    require_once("./$className.php");
                }],
                "checkFileExistence" => [function (string $className) {
                    $filePath = "./$className.php";

                    if (file_exists($filePath)) {
                        include_once($filePath);
                    }
                }]
            ];
        }

    }