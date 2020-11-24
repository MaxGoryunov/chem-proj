<?php

    namespace Tests\Routing;

    use PHPUnit\Framework\TestCase;
use Routing\AbstractHandler;
use Routing\IRoutingHandler;

/**
     * Testing AbstractHandler abstract class
     * 
     * @coversDefaultClass AbstractHandler
     */
    class AbstractHandlerTest extends TestCase {

        /**
         * Contains tested abstract class object
         *
         * @var AbstractHandler
         */
        protected $handler;

        /**
         * Creates tested abstract class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->handler = $this->getMockForAbstractClass(AbstractHandler::class);
        }

        /**
         * Removes tested abstract class
         *
         * @return void
         */
        protected function tearDown():void {
            $this->handler = null;
        }

        /**
         * @covers ::setNextHandler
         *
         * @return void
         */
        public function testSetNextHandlerReturnsSuppliedHandler():void {
            $nextHandler = $this->getMockBuilder(IRoutingHandler::class)
                            ->onlyMethods([])
                           ->getMock();

            $this->assertSame($nextHandler, $this->handler->setNextHandler($nextHandler));
        }
    }