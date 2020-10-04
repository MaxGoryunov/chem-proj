<?php

    namespace Tests\ControllerActions;

    use ControllerActions\IndexAction;
    use Controllers\IController;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing IndexAction class
     * 
     * @coversDefaultClass IndexAction
     */
    class IndexActionTest extends TestCase {

        public function testExecuteInvokesControllerMethod():void {
            $controller = $this->getMockBuilder(IController::class)
                          ->onlyMethods(["index", "add", "edit", "delete"])
                          ->getMock();

            $controller->expects($this->once())
                        ->method("index");

            $action = new IndexAction($controller);

            $this->assertNull($action->execute());
        }
    }