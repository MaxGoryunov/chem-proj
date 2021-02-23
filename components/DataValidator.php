<?php

    namespace Components;

use Closure;
use InvalidArgumentException;

    /**
     * Class for simple validating operations
     */
    class DataValidator {

        /**
         * Returns value associated with given key if it exists
         * 
         * @throws InvalidArgumentException if the value is not found
         *
         * @param string $key - key to be looked for
         * @param array $set  - dataset in which the key might be found
         * @return mixed
         */
        public function getFromSetOrThrowException(string $key, array $set) {
            if (isset($set[$key])) {
                return $set[$key];
            }

            throw new InvalidArgumentException("Value $key is not allowed in " . implode(", ", $set));
        }

        /**
         * Returns value if it exists in the given array or calls supplied function if the value is not found
         *
         * @param string $key      - key to be looked for
         * @param array $set       - dataset in which the key might be found
         * @param Closure $closure - actions to perform if the key was not found
         * @return void
         */
        public function getFromSetOrCallClosure(string $key, array $set, Closure $closure) {
            if (isset($set[$key])) {
                return $set[$key];
            }

            call_user_func($closure);
        }
    }