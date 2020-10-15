<?php

    namespace Tests\ControllerActions;

    use ControllerActions\DeleteAction;
    use Controllers\IController;
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

            $action = new DeleteAction($controller);

            $this->assertNull($action->execute(11));
        }
    }