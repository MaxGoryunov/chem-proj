<?php

    namespace Tests\Routing;

use ControllerActions\ControllerAction;
use DBQueries\IQueryBuilder;
use PHPUnit\Framework\TestCase;
    use ReflectionClass;
    use ReflectionMethod;
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

        /**
         * @covers ::handle
         *
         * @return void
         */
        public function testHandleReturnsActionIfNextHandlerDoesNotExist():void {
            $this->handler->expects($this->once())
                    ->method("fillData")
                    ->will($this->returnArgument(1));

            $uri    = ["root", "domain", "action"];
            $action = $this->getMockBuilder(ControllerAction::class)
                            ->getMock();

            $this->assertEquals($action, $this->handler->handle($uri, $action));
        }

        /**
         * @covers ::handle
         *
         * @return void
         */
        public function testHandleReturnsNextHandlerResults():void {
            $this->handler->expects($this->once())
                    ->method("fillData")
                    ->will($this->returnArgument(1));

            $handler = $this->createMock(AbstractHandler::class);

            $handler->expects($this->once())
                    ->method("handle")
                    ->will($this->returnCallback(function ($uri, ControllerAction $action) {
                        $action->setData(["id"]);

                        return $action;
                    }));

            $action = $this->getMockBuilder(ControllerAction::class)
                            ->getMock();

            $this->handler->setNextHandler($handler);

            $this->assertSame($action, $this->handler->handle([], $action));
        }
    }