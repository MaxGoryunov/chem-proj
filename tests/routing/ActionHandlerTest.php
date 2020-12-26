<?php

    namespace Tests\Routing;

use ControllerActions\AddAction;
use ControllerActions\EditAction;
use ControllerActions\IndexAction;
use PHPUnit\Framework\TestCase;
use Routing\ActionHandler;

/**
     * @coversDefaultClass ActionHandler
     */
    class ActionHandlerTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var ActionHandler
         */
        protected $handler;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->handler = new ActionHandler();
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
         * 
         * @dataProvider providePartedUriWithActionNames
         *
         * @return void
         */
        public function testHandleReturnsActionName(array $partedUri, string $expected):void {
            $this->assertContains($expected, $this->handler->handle($partedUri));
        }

        /**
         * @covers ::handle
         * 
         * @runInSeparateProcess
         *
         * @return void
         */
        public function testHandleRedirectsToErrorPageOnFailedInput():void {
            $partedUri = ["", "chem-proj", "addresses", "aaa"];

            $this->handler->handle($partedUri);
            $this->assertContains("Location: ./errors/not_found", xdebug_get_headers());
        }

        /**
         * @return (string|string[])[][]
         */
        public function providePartedUriWithActionNames():array {
            $offset = ["", "chem-proj", "addresses"];
            return [
                [array_merge($offset, ["add"]), AddAction::class],
                [array_merge($offset, ["edit", "12"]), EditAction::class],
                [array_merge($offset, ["list"]), IndexAction::class]
            ];
        }
    }