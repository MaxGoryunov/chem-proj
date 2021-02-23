<?php

    namespace Tests\Routing;

use ControllerActions\ControllerAction;
use Factories\AddressesFactory;
    use Factories\GendersFactory;
    use Factories\UserStatusesFactory;
    use PHPUnit\Framework\TestCase;
    use Routing\FactoryHandler;

    /**
     * Testing FactoryHandler class
     * 
     * @coversDefaultClass FactoryHandler
     */
    class FactoryHandlerTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var FactoryHandler
         */
        protected $handler;

        /**
         * Contains support class for Testing
         *
         * @var ControllerAction
         */
        protected $action;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->handler = new FactoryHandler();
            $this->action  = new ControllerAction();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->handler = null;
            $this->action  = null;
        }

        /**
         * @covers ::handle
         * 
         * @dataProvider providePartedUriWithValidFactoryName
         *
         * @param string[] $partedUri - array of URI parts
         * @param string $expected    - expected result
         * @return void
         */
        public function testHandleReturnsFactory(array $partedUri, string $expected):void {            
            $this->assertInstanceOf($expected, $this->handler->handle($partedUri, $this->action)->getFactory());
        }

        /**
         * @covers ::handle
         * 
         * @runInSeparateProcess
         *
         * @return void
         */
        public function testHandleRedirectsToErrorPageOnFailedInput():void {
            $partedUri = ["", "chem-proj", "aaa"];

            $this->handler->handle($partedUri, $this->action);
            $this->assertContains("Location: ./errors/not_found", xdebug_get_headers());
        }

        /**
         * @return (string|string[])[][]
         */
        public function providePartedUriWithValidFactoryName():array {
            $offset = ["", "chem-proj"];

            return [
                [array_merge($offset, ["addresses", "edit", "12"]), AddressesFactory::class],
                [array_merge($offset, ["genders", "add"]), GendersFactory::class],
                [array_merge($offset, ["user_statuses", "index"]), UserStatusesFactory::class]
            ];
        }
    }