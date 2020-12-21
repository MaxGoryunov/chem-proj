<?php

    namespace Tests\ControllerActions;

    use PHPUnit\Framework\TestCase;
    use controllerActions\AbstractAction;
    use Controllers\IController;
    use ReflectionClass;

    /**
     * @coversDefaultClass AbstractAction
     */
    class AbstractActionTest extends TestCase {

        /**
         * Returns all the variables needed for testing
         *
         * @return array
         */
        private function setMocks(string $factoryInterface):array {
            $factory = $this->getMockBuilder($factoryInterface)
                        ->getMock();

            $controller = $this->getMockBuilder(IController::class)
                            ->onlyMethods(["index", "add", "edit", "delete"])
                            ->getMock();

            $action = $this->getMockBuilder(AbstractAction::class)
                        ->setConstructorArgs([$factory])
                        ->getMock();

            return compact("factory", "controller", "action");
        }

        /**
         * @covers ::__construct
         * @covers ::getController
         *
         * @return void
         */
        public function testGetControllerReturnsProxyIfFactoryCanCreateProxies():void {
            extract($this->setMocks(IProxyFactory::class));

            $factory->expects($this->once())
                        ->method("getProxy")
                        ->will($this->returnValue($controller));

            $reflection    = new ReflectionClass($action);
            $getController = $reflection->getMethod("getController");

            $getController->setAccessible(true);

            $this->AssertInstanceOf(IController::class, $getController->invoke($action));
        }
    }