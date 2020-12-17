<?php

    namespace Tests\ControllerActions;

    use ControllerActions\IndexAction;
    use Controllers\IController;
use Factories\AbstractFactory;
use PHPUnit\Framework\TestCase;

    /**
     * Testing IndexAction class
     * 
     * @coversDefaultClass IndexAction
     */
    class IndexActionTest extends TestCase {

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
                        ->method("index");

            $factory = $this->getMockForAbstractClass(AbstractFactory::class);

            $factory->expects($this->any())
                    ->method("getProxy")
                    ->will($this->returnValue($controller));

            $action = new IndexAction($factory);

            $this->assertNull($action->execute());
        }
    }