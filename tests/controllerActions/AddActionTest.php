<?php

    namespace Tests\ControllerActions;

    use ControllerActions\AddAction;
    use Controllers\IController;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing AddAction class
     * 
     * @coversDefaultClass AddAction
     */
    class AddActionTest extends TestCase {

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
                       ->method("add");

            $action = new AddAction($controller);

            $this->assertNull($action->execute());
        }
    }