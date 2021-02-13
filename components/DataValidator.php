<?php

    namespace Components;

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
         * @param string $key
         * @param array $set
         * @return mixed
         */
        public function GetFromSetOrThrowException(string $key, array $set) {
            if (array_key_exists($key, $set)) {
                return $set[$key];
            }

            throw new InvalidArgumentException("Value $key is not allowed in " . implode(", ", $set));
        }
    }