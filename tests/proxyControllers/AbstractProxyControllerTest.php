<?php

    namespace Tests\ProxyControllers;

use Controllers\AbstractController;
use Factories\AbstractMVCPDMFactory;
use PHPUnit\Framework\TestCase;
use ProxyControllers\AbstractProxyController;
use ReflectionClass;
use ReflectionMethod;

/**
     * Testing AbstractProxyController class
     * 
     * @coversDefaultClass AbstractProxyController
     */
    class AbstractProxyControllerTest extends TestCase {

        /**
         * Contains tested abstract class object
         *
         * @var AbstractProxyController
         */
        protected $abstractProxyController;

        /**
         * Creates tested abstract class object
         *
         * @return void
         */
        protected function setUp():void {
            $factory = $this->getMockForAbstractClass(AbstractMVCPDMFactory::class);

            $factory->expects($this->any())
                    ->method("getController")
                    ->will($this->returnValue($this->getMockForAbstractClass(AbstractController::class, [$factory])));

            $this->abstractProxyController = $this->getMockForAbstractClass(AbstractProxyController::class, [$factory]);
        }

        /**
         * Removes tested abstract class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->abstractProxyController = null;
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
            $abstractProxyController = new ReflectionClass(AbstractProxyController::class);
            $method             = $abstractProxyController->getMethod($methodName);
            $method->setAccessible(true);

            return $method;
        }

        /**
         * @covers ::getController
         *
         * @return void
         */
        public function testGetController():void {
            $getController = self::getMethod("getController");

            $this->assertInstanceOf(AbstractController::class, $getController->invoke($this->abstractProxyController));
        }
    }