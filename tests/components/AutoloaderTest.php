<?php

    namespace Tests\Components;

    use Closure;
    use Components\Autoloader;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing Autoloader class
     * 
     * @coversDefaultClass Components\Autoloader
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
         * @small
         *
         * @return void
         */
        public function testRegisterMethodRegistersDefaultFunction():void {
            $this->assertNull($this->autoloader->register());

            $this->assertContains("spl_autoload", $this->autoloader->getAutoloaders());
            /**
             * Asserting 2 because of PHPUnit's autoloader
             */
            $this->assertCount(2, $this->autoloader->getAutoloaders());
        }

        /**
         * @covers ::registerUserAutoloader
         * @covers ::getAutoloaders
         * 
         * @dataProvider provideAutoloaderFunctions
         * 
         * @small
         *
         * @param Closure $func
         * @return void
         */
        public function testRegisterUserAutoloaderMethodRegistersSuppliedFunction(Closure $func):void {
            $this->assertNotContains($func, $this->autoloader->getAutoloaders());

            $this->autoloader->registerUserAutoloader($func);

            $this->assertContains($func, $this->autoloader->getAutoloaders());
            /**
             * Asserting 3 because of PHPUnit's autoloader and spl_autoload
             */
            $this->assertCount(3, $this->autoloader->getAutoloaders());

            spl_autoload_unregister($func);
        }

        /**
         * @covers ::registerUserAutoloader
         * @covers ::unregisterUserAutoloader
         * @covers ::getAutoloaders
         * 
         * @dataProvider provideAutoloaderFunctions
         * 
         * @small
         *
         * @param Closure $func
         * @return void
         */
        public function testUnregisterUserAutoloaderMethodUnregistersSuppliedFunction(Closure $func):void {
            $this->autoloader->registerUserAutoloader($func);

            $this->assertContains($func, $this->autoloader->getAutoloaders());

            $this->assertNull($this->autoloader->unregisterUserAutoloader($func));

            $this->assertNotContains($func, $this->autoloader->getAutoloaders());

            $this->assertCount(2, $this->autoloader->getAutoloaders());
        }

        /**
         * @covers ::unregisterUserAutoloader
         * @covers ::getAutoloaders
         * 
         * @small
         *
         * @return void
         */
        public function testUnregisterMethodDoesNothingOnEmptyInput():void {
            $autoloaderCount = count($this->autoloader->getAutoloaders());

            $this->autoloader->unregisterUserAutoloader();

            $this->assertEquals($autoloaderCount, count($this->autoloader->getAutoloaders()));
        }

        /**
         * @covers ::unregisterUserAutoloader
         * @covers ::register
         * @covers ::getAutoloaders
         * 
         * @small
         *
         * @return void
         */
        public function testRegisterUnregisterDefaultFunctionSequence():void {
            $this->assertCount(2, $this->autoloader->getAutoloaders());

            $this->autoloader->register();

            $this->assertCount(2, $this->autoloader->getAutoloaders());

            $this->autoloader->unregisterUserAutoloader();

            $this->assertCount(2, $this->autoloader->getAutoloaders());

            $this->autoloader->register();

            $this->assertCount(2, $this->autoloader->getAutoloaders());
        }

        /**
         * @covers ::register
         * 
         * @small
         *
         * @return void
         */
        public function testRegisterSpeed():void {
            $time = microtime(true);

            for ($i = 0; $i < 100000; $i++) { 
                $this->autoloader->register();
            }

            $time = microtime(true) - $time;

            $this->assertLessThan(3, $time);
        }

        /**
         * Provides functions for 'register' method
         *
         * @return Closure[][]
         */
        public function provideAutoloaderFunctions():array {
            return [
                "include"            => [function (string $className) {
                    @include_once("./$className.php");
                }],
                "require"            => [function (string $className) {
                    @require_once("./$className.php");
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