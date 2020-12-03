<?php

    namespace Tests\Routing;

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
         * Returns protected or private class method
         *
         * @param string $methodName
         * @return ReflectionMethod
         */
        protected function getInnerMethod(string $methodName):ReflectionMethod {
            $reflection = new ReflectionClass(AbstractHandler::class);
            $method     = $reflection->getMethod($methodName);

            $method->setAccessible(true);

            return $method;
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
         * @covers ::passToNext
         * 
         * @dataProvider provideIds
         *
         * @return void
         */
        public function testPassToNextContainsNextHandlerResults(int $id):void {
            $nextHandler = $this->getMockBuilder(IRoutingHandler::class)
                            ->onlyMethods(["handle", "setNextHandler"])
                            ->getMock();

            $nextHandler->expects($this->once())
                        ->method("handle")
                        ->will($this->returnValue(["id" => $id]));

            $this->handler->setNextHandler($nextHandler);

            $passToNext = $this->getInnerMethod("passToNext");

            $this->assertEquals(["id" => $id], $passToNext->invokeArgs($this->handler, [[], []]));
        }

        /**
         * @covers ::passToNext
         *
         * @return void
         */
        public function testPassToNextReturnsGivenArrayIfNextHandlerIsNotSet():void {
            $passToNext = $this->getInnerMethod("passToNext");
            $invokeData = ["action" => "action", "id" => 123];

            $this->assertEquals($invokeData, $passToNext->invokeArgs($this->handler, [[], $invokeData]));
        }

        /**
         * @return int[][]
         */
        public function provideIds():array {
            return [
                [1],
                [23],
                [113]
            ];
        }
    }