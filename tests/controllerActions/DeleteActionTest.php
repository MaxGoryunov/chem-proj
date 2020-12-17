<?php

    namespace Tests\ControllerActions;

    use ControllerActions\DeleteAction;
    use Controllers\IController;
use Factories\AbstractFactory;
use PHPUnit\Framework\TestCase;

    /**
     * Testing DeleteAction class
     * 
     * @coversDefaultClass DeleteAction
     */
    class DeleteActionTest extends TestCase {

        /**
         * @covers ::execute
         *
         * @return void
         */
        public function testExecuteInvokesControllerMethod():void {
            $controller = $this->getMockBuilder(IController::class)
                          ->onlyMethods(["index", "add", "edit", "delete"])
                          ->getMock();

            $controller->expects($this->once())
                       ->method("delete");

            $factory = $this->getMockForAbstractClass(AbstractFactory::class);

            $factory->expects($this->once())
                    ->method("getProxy")
                    ->will($this->returnValue($controller));

            $action = new DeleteAction($factory);

            $this->assertNull($action->execute(11));
        }
    }