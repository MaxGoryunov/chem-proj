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
         * @covers ::__construct
         * @covers ::getLastBreakpoint
         *
         * @return void
         */
        public function testTimerSetsBreakpointOnCreation():void {
            $timer       = new Timer();
            $currentTime = microtime(true);

            $this->assertEquals(0, bccomp($currentTime, $timer->getLastBreakpoint(), 3));
        }
    }