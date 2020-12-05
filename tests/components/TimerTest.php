<?php

    namespace Tests\Components;

    use Components\Timer;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing Timer class
     * 
     * @coversDefaultClass Timer
     */
    class TimerTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var Timer
         */
        protected $timer;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->timer = new Timer();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->timer = null;
        }

        /**
         * @covers ::__construct
         * @covers ::getLastBreakpoint
         *
         * @return void
         */
        public function testTimerSetsBreakpointOnCreation():void {
            $currentTime = microtime(true);

            $this->assertEquals(0, bccomp($currentTime, $this->timer->getLastBreakpoint(), 3));
        }

        /**
         * @covers ::__construct
         * @covers ::getLastBreakpoint
         *
         * @return void
         */
        public function testTimerDoesNotSetBreakpointOnCreationIfItIsDefinedInTheConstructor():void {
            $timer = new Timer(false);

            $this->assertEquals(0, $timer->getLastBreakpoint());
        }
    }