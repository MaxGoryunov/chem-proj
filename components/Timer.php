<?php

    namespace Components;

    /**
     * Class for testing speed of other classes' methods
     */
    class Timer {

        /**
         * Contains breakpoints for calculating performance
         *
         * @var float[]
         */
        private $breakpoints = [];

        /**
         * Contains the number of breakpoints
         *
         * @var int
         */
        private $length = 0;

        /**
         * Sets the first breakpoint
         */
        public function __construct(bool $setUpBreakpoint = true) {
            if ($setUpBreakpoint) {
                $this->breakpoints[] = microtime(true);
                $this->length = 1;
            }
        }

        /**
         * Returns the last breakpoint
         *
         * @return float
         */
        public function getLastBreakpoint():float {
            return $this->breakpoints[$this->length - 1] ?? 0;
        }

        /**
         * Creates a new breakpoint
         *
         * @return void
         */
        public function breakpoint():void {
            $this->breakpoints[] = microtime(true);
            $this->length++;
        }
    }