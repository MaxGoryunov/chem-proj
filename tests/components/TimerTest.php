<?php

    namespace Tests\Components;

    use Components\Timer;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing Timer class
     * 
     * @coversDefaultClass Components\Timer
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
         * @small
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
         * @small
         *
         * @return void
         */
        public function testTimerDoesNotSetBreakpointOnCreationIfItIsDefinedInTheConstructor():void {
            $timer = new Timer(false);

            $this->assertEquals(0, $timer->getLastBreakpoint());
        }

        /**
         * @covers ::__construct
         * @covers ::breakpoint
         * @covers ::getLastBreakpoint
         * 
         * @medium
         *
         * @return void
         */
        public function testTimerAddsBreakpoint():void {
            $currentTime = microtime(true);

            $this->assertNull($this->timer->breakpoint());
            $this->assertEquals(0, bccomp($currentTime, $this->timer->getLastBreakpoint(), 3));

            sleep(1);

            $currentTime = microtime(true);

            $this->assertNull($this->timer->breakpoint());
            $this->assertEquals(0, bccomp($currentTime, $this->timer->getLastBreakpoint(), 3));

            sleep(1);
            $currentTime = microtime(true);

            $this->assertNull($this->timer->breakpoint());
            $this->assertEquals(0, bccomp($currentTime, $this->timer->getLastBreakpoint(), 3));
        }

        /**
         * @covers ::__construct
         * @covers ::breakpoint
         * @covers ::getLastBreakpoint
         * @covers ::getAllBreakpoints
         * 
         * @medium
         *
         * @return void
         */
        public function testGetAllBreakpointsReturnsAllBreakpoints():void {
            for ($i = 0; $i < 3; $i++) { 
                $times[] = microtime(true);

                $this->timer->breakpoint();
                $this->assertEquals(0, bccomp($times[$i], $this->timer->getLastBreakpoint(), 3));
                $this->assertCount(2 + $i, $this->timer->getAllBreakpoints());

                sleep(1 + $i);
            }
        }

        /**
         * @covers ::__construct
         * @covers ::breakpoint
         * @covers ::getLastInterval
         * 
         * @medium
         *
         * @return void
         */
        public function testGetLastIntervalReturnsLastInterval():void {
            $this->assertEquals(0, $this->timer->getLastInterval());

            $times[] = microtime(true);
            $this->timer->breakpoint();

            sleep(2);

            $times[] = microtime(true);
            $this->timer->breakpoint();

            $this->assertEquals(0, bccomp($times[1] - $times[0], $this->timer->getLastInterval(), 4));
        }

        /**
         * @covers ::__construct
         * @covers ::breakpoint
         * @covers ::getLastInterval
         * @covers ::getAllIntervals
         * 
         * @medium
         *
         * @return void
         */
        public function testGetAllIntervalsReturnsAllIntervals():void {
            $times[] = microtime(true);
            $this->timer->breakpoint();

            for ($i = 0; $i < 3; $i++) {
                sleep(1 + $i);

                $times[] = microtime(true);

                $this->timer->breakpoint();
                $this->assertEquals(0, bccomp($times[1 + $i] - $times[$i], $this->timer->getLastInterval(), 3));
                $this->assertCount(2 + $i, $this->timer->getAllIntervals());
            }
        }
    }