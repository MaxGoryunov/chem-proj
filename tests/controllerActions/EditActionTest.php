<?php

    namespace Tests\ControllerActions;

    use ControllerActions\EditAction;
    use Controllers\IController;
use Factories\AbstractFactory;
use PHPUnit\Framework\TestCase;

    /**
     * Testing EditAction class
     * 
     * @coversDefaultClass EditAction
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

            $factory = $this->getMockForAbstractClass(AbstractFactory::class);

            $factory->expects($this->once())
                    ->method("getProxy")
                    ->will($this->returnValue($controller));

            $action = new EditAction($factory);

            $this->assertNull($action->execute(12));
        }
    }