<?php

    namespace Tests\Routing;

    use ControllerActions\ControllerAction;
    use PHPUnit\Framework\TestCase;
    use Routing\ActionHandler;

    /**
     * @coversDefaultClass Routing\ActionHandler
     */
    class ActionHandlerTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var ActionHandler
         */
        protected $handler;

        /**
         * Contains helper object for testing
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
            $this->handler = new ActionHandler();
            $this->action  = new ControllerAction();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->handler = null;
        }

        /**
         * @covers ::handle
         * @covers ::fillData
         * 
         * @uses ControllerActions\ControllerAction
         * 
         * @dataProvider providePartedUriWithActionNames
         * 
         * @small
         *
         * @return void
         */
        public function testHandleReturnsActionName(array $partedUri, string $expected):void {
            $this->assertEquals($expected, $this->handler->handle($partedUri, $this->action)->getActionName());
        }

        /**
         * @covers ::handle
         * @covers ::fillData
         * 
         * @small
         * 
         * @runInSeparateProcess
         *
         * @return void
         */
        public function testHandleRedirectsToErrorPageOnFailedInput():void {
            $partedUri = ["", "chem-proj", "addresses", "aaa"];

            $this->handler->handle($partedUri, $this->action);
            $this->assertContains("Location: ./errors/not_found", xdebug_get_headers());
        }

        /**
         * @return (string|string[])[][]
         */
        public function providePartedUriWithActionNames():array {
            $offset = ["", "chem-proj", "addresses"];
            return [
                [array_merge($offset, ["add"]), "add"],
                [array_merge($offset, ["edit", "12"]), "edit"],
                [array_merge($offset, ["list"]), "index"]
            ];
        }
    }