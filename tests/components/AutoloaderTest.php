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
            $this->autoloader->register($func);

            $this->assertContains($func, $this->autoloader->getAutoloaders());
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