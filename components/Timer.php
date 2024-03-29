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
         * Contains intervals between breakpoints
         *
         * @var float[]
         */
        private $intervals = [];

        /**
         * Contains the number of breakpoints
         *
         * @var int
         */
        private $length = -1;

        /**
         * Sets the first breakpoint
         */
        public function __construct(bool $setUpBreakpoint = true) {
            if ($setUpBreakpoint) {
                $this->breakpoints[] = microtime(true);
                $this->length = 0;
            }
        }

        /**
         * Returns all stored breakpoints
         *
         * @return float[]
         */
        public function getAllBreakpoints():array {
            return $this->breakpoints;
        }

        /**
         * Returns the last breakpoint
         *
         * @return float
         */
        public function getLastBreakpoint():float {
            return $this->breakpoints[$this->length] ?? 0;
        }

        /**
         * Returns all intervals
         *
         * @return float[]
         */
        public function getAllIntervals():array {
            return $this->intervals;
        }

        /**
         * Returns the time interval between the last two breakpoints
         *
         * @return float
         */
        public function getLastInterval():float {
            return $this->intervals[$this->length - 1] ?? 0;
        }

        /**
         * Creates a new breakpoint
         *
         * @return void
         */
        public function breakpoint():void {
            $this->breakpoints[] = microtime(true);
            $this->length++;

            if ($this->length > 0) {
                $this->intervals[] = $this->breakpoints[$this->length] - $this->breakpoints[$this->length - 1];
            }
        }
    }