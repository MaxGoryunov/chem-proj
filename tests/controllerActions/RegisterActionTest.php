<?php

    namespace Tests\ControllerActions;

    use ControllerActions\RegisterAction;
    use Controllers\IController;
    use Factories\AbstractFactory;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing RegisterAction class 
     * 
     * @coversDefaultClass RegisterAction
     */
    class RegisterActionTest extends TestCase {

        /**
         * @covers ::execute
         *
         * @return void
         */
        public function testExecuteInvokesControllerMethod():void {
            $controller = $this->getMockBuilder(IController::class)
                          ->onlyMethods(["index", "add", "edit", "delete"])
                          ->addMethods(["register"])
                          ->getMock();

            $controller->expects($this->once())
                       ->method("register");

            $factory = $this->getMockForAbstractClass(AbstractFactory::class);

            $factory->expects($this->once())
                    ->method("getProxy")
                    ->will($this->returnValue($controller));

            $action = new RegisterAction($factory);

            $this->assertNull($action->execute());
        }
    }