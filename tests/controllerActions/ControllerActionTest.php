<?php

    namespace Tests\ControllerActions;

    use PHPUnit\Framework\TestCase;
    use ControllerActions\ControllerAction;
    use Controllers\IController;
    use Factories\IControllerFactory;
    use Factories\IProxyFactory;
    use InvalidArgumentException;
    use LogicException;
    use ReflectionClass;

    /**
     * @coversDefaultClass ControllerActions\ControllerAction
     */
    class ControllerActionTest extends TestCase {

        /**
         * Contains testes class object
         *
         * @var ControllerAction
         */
        protected $action;

        /**
         * Creates Tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->action = new ControllerAction();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->action = null;
        }

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
         * @covers ::setFactory
         * @covers ::getFactory
         *
         * @return void
         */
        public function testSetFactorySetsFactory():void {
            $factory = $this->getMockBuilder(IControllerFactory::class)
                            ->getMock();

            $this->action->setFactory($factory);

            $this->assertSame($factory, $this->action->getFactory());
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

            $this->action->setActionName("aaa");
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

            $this->action->setActionName($actionName);

            $this->assertEquals($actionName, $this->action->getActionName());
        }

        /**
         * @covers ::addData
         * @covers ::getData
         *
         * @return void
         */
        public function testAddDataSetsControllerData():void {
            $this->action->addData("id", 33);

            $data["id"] = 33;
            $this->assertEquals($data, $this->action->getData());

            $this->action->addData("name", "John");

            $data["name"] = "John";
            $this->assertEquals($data, $this->action->getData());
        }

        /**
         * @covers ::setFactory
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

            $this->action->setFactory($factory);

            $reflection    = new ReflectionClass($this->action);
            $getController = $reflection->getMethod("getController");

            $getController->setAccessible(true);

            $this->assertSame($controller, $getController->invoke($this->action));
            $this->assertEquals(1, $factory->counter);
        }

        /**
         * @covers ::setFactory
         * @covers ::getController
         *
         * @return void
         */
        public function testGetControllerReturnsControllerIfFactoryCannotCreateProxies():void {
            $controller = $this->setMocks();

            $factory = $this->getMockBuilder(IControllerFactory::class)
                        ->onlyMethods(["getController"])
                        ->getMock();

            $this->action->setFactory($factory);
            
            $reflection    = new ReflectionClass($this->action);
            $getController = $reflection->getMethod("getController");

            $factory->expects($this->once())
                    ->method("getController")
                    ->willReturn($controller);

            $getController->setAccessible(true);

            $this->assertSame($controller, $getController->invoke($this->action));
        }

        /**
         * @covers ::getActionName
         * @covers ::getController
         * @covers ::setActionName
         * @covers ::setFactory
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
            
            $this->action->setFactory($factory);
            $this->action->setActionName("edit");

            $factory->expects($this->once())
                    ->method("getController")
                    ->willReturn($controller);

            $controller->expects($this->once())
                        ->method("edit")
                        ->with($id);

            $this->assertNull($this->action->execute($id));
        }

        /**
         * @covers ::getActionName
         * @covers ::getController
         * @covers ::setActionName
         * @covers ::setFactory
         * @covers ::execute
         *
         * @return void
         */
        public function testExecuteThrowsExceptionWhenIdIsNotSuppliedAsAParamForTheActionWhichRequiresId():void {
            $this->expectException(LogicException::class);

            $factory = $this->getMockBuilder(IControllerFactory::class)
                            ->getMock();

            $this->action  = new ControllerAction();

            $this->action->setFactory($factory);
            $this->action->setActionName("edit");

            $this->action->execute();
        }

        /**
         * @covers ::getActionName
         * @covers ::getController
         * @covers ::setActionName
         * @covers ::setFactory
         * @covers ::execute
         *
         * @return void
         */
        public function testExecuteInvokesControllerMethodWhenIdIsNotGivenAndActionDoesNotRequireIt():void {
            $factory = $this->getMockBuilder(IControllerFactory::class)
                            ->getMock();

            $controller = $this->getMockBuilder(IController::class)
                                ->getMock();

            $this->action->setFactory($factory);
            $this->action->setActionName("index");

            $factory->expects($this->once())
                    ->method("getController")
                    ->willReturn($controller);

            $controller->expects($this->once())
                        ->method("index")
                        ->with();

            $this->assertNull($this->action->execute());
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
         * @return int[][][]
         */
        public function provideControllerData():array {
            return [
                [[1]],
                [[13]],
                [[25]]
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