<?php

    namespace Tests\ControllerActions;

    use ControllerActions\EditAction;
    use Controllers\IController;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing EditAction class
     * 
     * @covers EditAction
     */
    class EditActionTest extends TestCase {

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
                       ->method("edit");

            $action = new EditAction($controller);

            $this->assertNull($action->execute(12));
        }
    }