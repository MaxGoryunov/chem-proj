<?php

    namespace Tests\ControllerActions;

    use PHPUnit\Framework\TestCase;
    use controllerActions\AbstractAction;
    use Controllers\IController;
    use Factories\IControllerFactory;
    use Factories\IProxyFactory;
    use ReflectionClass;

    /**
     * @coversDefaultClass AbstractAction
     */
    class AbstractActionTest extends TestCase {

        /**
         * Returns all the variables needed for testing
         *
         * @return IController
         */
        private function setMocks() {
            $controller = $this->getMockBuilder(IController::class)
                            ->onlyMethods(["index", "add", "edit", "delete"])
                            ->getMock();

            return $controller;
        }

        /**
         * @covers ::__construct
         * @covers ::getController
         *
         * @return void
         */
        public function testGetControllerReturnsProxyIfFactoryCanCreateProxies():void {
            $controller = $this->setMocks();

            $factory = new class($controller) implements IProxyFactory {
                public $counter = 0;

                private $controller;

                public function __construct($controller) {
                    $this->controller = $controller;
                }

                public function getController():IController {
                    return $this->controller;
                }

                public function getProxy():IController {
                    $this->counter++;

                    return $this->controller;
                }
            };

            $action = $this->getMockBuilder(AbstractAction::class)
                        ->setConstructorArgs([$factory])
                        ->getMock();

            $reflection    = new ReflectionClass($action);
            $getController = $reflection->getMethod("getController");

            $getController->setAccessible(true);

            $this->assertSame($controller, $getController->invoke($action));
            $this->assertEquals(1, $factory->counter);
        }

        /**
         * @covers ::__construct
         * @covers ::getController
         *
         * @return void
         */
        public function testGetControllerReturnsControllerIfFactoryCannotCreateProxies():void {
            $controller = $this->setMocks();

            $factory = $this->getMockBuilder(IControllerFactory::class)
                        ->onlyMethods(["getController"])
                        ->getMock();

            $action = $this->getMockBuilder(AbstractAction::class)
                            ->setConstructorArgs([$factory])
                            ->getMock();

            $reflection    = new ReflectionClass($action);
            $getController = $reflection->getMethod("getController");

            $factory->expects($this->once())
                    ->method("getController")
                    ->willReturn($controller);

            $getController->setAccessible(true);

            $this->assertSame($controller, $getController->invoke($action));
        }
    }