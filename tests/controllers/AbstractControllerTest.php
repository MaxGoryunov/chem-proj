<?php

    namespace Tests\Controllers;

    use Controllers\AbstractController;
    use Factories\AbstractMVCPDMFactory;
    use Models\AbstractModel;
    use PHPUnit\Framework\TestCase;
    use ReflectionClass;
    use ReflectionMethod;
    use Views\AbstractView;

    /**
     * Testing AbstractController abstract class
     * 
     * @coversDefaultClass AbstractController
     */
    class AbstractControllerTest extends TestCase {

        /**
         * Contains tested abstract class object
         *
         * @var AbstractController
         */
        protected $abstractController;

        /**
         * Creates tested abstract class object
         * 
         * Controller accepts Factory in the constructor, so we need to mock it and its methods beforehand
         *
         * @return void
         */
        protected function setUp():void {
            $factory = $this->getMockForAbstractClass(AbstractMVCPDMFactory::class);

            $factory->expects($this->any())
                    ->method("getModel")
                    ->will($this->returnValue($this->getMockForAbstractClass(AbstractModel::class, [$factory])));

            $factory->expects($this->any())
                    ->method("getView")
                    ->will($this->returnValue($this->getMockForAbstractClass(AbstractView::class)));

            $this->abstractController = $this->getMockForAbstractClass(AbstractController::class, [$factory]);
        }

        /**
         * Removes tested abstract class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->abstractController = null;
        }

        /**
         * Returns an accessible protected method
         * 
         * THIS IS NOT A TEST
         *
         * @param string $methodName
         * @return ReflectionMethod
         */
        protected static function getMethod(string $methodName):ReflectionMethod {
            $abstractController = new ReflectionClass(AbstractController::class);
            $method             = $abstractController->getMethod($methodName);
            $method->setAccessible(true);

            return $method;
        }

        /**
         * @covers ::getModel
         *
         * @return void
         */
        public function testGetModel():void {
            $getModel = self::getMethod("getModel");

            $this->assertInstanceOf(AbstractModel::class, $getModel->invoke($this->abstractController));
        }

        /**
         * @covers ::getView
         *
         * @return void
         */
        public function testGetView():void {
            $getView = self::getMethod("getView");

            $this->assertInstanceOf(AbstractView::class, $getView->invoke($this->abstractController));
        }
    }