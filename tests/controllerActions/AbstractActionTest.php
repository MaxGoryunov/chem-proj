<?php

    namespace Tests\ControllerActions;

    use PHPUnit\Framework\TestCase;
    use controllerActions\AbstractAction;
    use Controllers\IController;
    use Factories\IControllerFactory;
    use Factories\IProxyFactory;
    use InvalidArgumentException;
use LogicException;
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
         * @covers ::setActionName
         *
         * @return void
         */
        public function testSetActionNameThrowsLogicExceptionOnWrongActionNameInput():void {
            $this->expectException(InvalidArgumentException::class);

            $factory = $this->getMockBuilder(IControllerFactory::class)
                            ->getMock();

            $action = new AbstractAction($factory);

            $action->setActionName("aaa");
        }

        /**
         * @covers ::setActionName
         * @covers ::getActionName
         * 
         * @dataProvider provideActionNames
         *
         * @return void
         */
        public function testSetGetActionNameReturnsActionName(string $actionName):void {
            $factory = $this->getMockBuilder(IControllerFactory::class)
                            ->getMock();

            $action = new AbstractAction($factory);

            $action->setActionName($actionName);

            $this->assertEquals($actionName, $action->getActionName());
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

            $action = new AbstractAction($factory);

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

            $action = new AbstractAction($factory);
            
            $reflection    = new ReflectionClass($action);
            $getController = $reflection->getMethod("getController");

            $factory->expects($this->once())
                    ->method("getController")
                    ->willReturn($controller);

            $getController->setAccessible(true);

            $this->assertSame($controller, $getController->invoke($action));
        }

        /**
         * @covers ::execute
         * 
         * @dataProvider provideIds
         *
         * @param int $id
         * @return void
         */
        public function testExecuteInvokesControllerMethodWithTheIdWhenTheIdIsRequired(int $id):void {
            $factory = $this->getMockBuilder(IControllerFactory::class)
                            ->getMock();

            $controller = $this->getMockBuilder(IController::class)
                                ->getMock();

            $action = new AbstractAction($factory);

            $action->setActionName("edit");

            $factory->expects($this->once())
                    ->method("getController")
                    ->willReturn($controller);

            $controller->expects($this->once())
                        ->method("edit")
                        ->with($id);

            $this->assertNull($action->execute($id));
        }

        /**
         * @covers ::execute
         *
         * @return void
         */
        public function testExecuteThrowsExceptionWhenIdIsNotSuppliedAsAParamForTheActionWhichRequiresId():void {
            $this->expectException(LogicException::class);

            $factory = $this->getMockBuilder(IControllerFactory::class)
                            ->getMock();

            $action  = new AbstractAction($factory);

            $action->setActionName("edit");

            $action->execute();
        }

        /**
         * @covers ::execute
         *
         * @return void
         */
        public function testExecuteInvokesControllerMethodWhenIdIsNotGivenAndActionDoesNotRequireIt():void {
            $factory = $this->getMockBuilder(IControllerFactory::class)
                            ->getMock();

            $controller = $this->getMockBuilder(IController::class)
                                ->getMock();

            $action = new AbstractAction($factory);

            $action->setActionName("index");

            $factory->expects($this->once())
                    ->method("getController")
                    ->willReturn($controller);

            $controller->expects($this->once())
                        ->method("index")
                        ->with();

            $this->assertNull($action->execute());
        }

        /**
         * @return string[][]
         */
        public function provideActionNames():array {
            return [
                ["index"],
                ["edit"],
                ["add"]
            ];
        }

        /**
         * @return int[][]
         */
        public function provideIds():array {
            return [
                [1],
                [13],
                [20]
            ];
        }
    }