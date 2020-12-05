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
         * Sets the first breakpoint
         */
        public function __construct(bool $setUpBreakpoint = true) {
            if ($setUpBreakpoint) {
                $this->breakpoints[] = microtime(true);
            }
        }

        /**
         * Returns the last breakpoint
         *
         * @return float
         */
        public function getLastBreakpoint():float {
            return $this->breakpoints[array_key_last($this->breakpoints)] ?? 0;
        }
    }