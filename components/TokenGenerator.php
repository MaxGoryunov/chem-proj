<?php

    namespace Components;
    
    /**
     * Class for creating tokens. Will be used later to create tokens for user connections
     */
    class TokenGenerator {

        /**
         * Key for generating only token with symbols from [0-9] range
         * 
         * @var string[]
         */
        public const DIGITS = ["09"];

        /**
         * Key for generating only token with symbols from [a-Z] range
         * 
         * @var string[]
         */
        public const LETTERS = ["az", "AZ"];

        /**
         * Key for generating only token with symbols from [a-z] range
         * 
         * @var string[]
         */
        public const LETTERS_LOWERCASE = ["az"];

        /**
         * Initiated ranges which can be used for generating tokens
         *
         * @var array
         */
        private$ranges = [];

        /**
         * Symbols used to create a token
         *
         * @var string[]
         */
        private $symbols = [];

        /**
         * Sets the predefined ranges state to false
         */
        public function __construct() {
            $this->ranges = [
                $this->getKey(self::DIGITS)            => [],
                $this->getKey(self::LETTERS)           => [],
                $this->getKey(self::LETTERS_LOWERCASE) => []
            ];
        }

        /**
         * Returns a generated key based on the given array
         *
         * @param string[] $range
         * @return string
         */
        private function getKey(array $range):string {
            return implode("", $range);
        }

        /**
         * Controls creation of symbols used in tokens
         * 
         * The resulting array depends on the keys supplied in $keys variable and may include digits, letters or both digits and letters.
         * 
         * @todo Implement a more effective algorithm
         *
         * @param string[][] $keys
         * @return (int|string)[]
         */
        public function initSymbols(array $keys):array {
            foreach ($keys as $ranges) {
                $rangeKey = $this->getKey($ranges);

                /**
                 * If the range is empty then the is is created from smaller ranges
                 */
                if ($this->ranges[$rangeKey] === []) {
                    $generatedRanges = [];

                    foreach ($ranges as $range) {
                        $generatedRanges[] = range(...str_split($range));
                    }

                    $this->ranges[$rangeKey] = array_merge(...$generatedRanges);
                }
            }

            $this->symbols = array_merge(...array_values($this->ranges));

            return $this->symbols;
        }

        /**
         * Function returns a token, user can specify the token length if needed
         *
         * @param int $length - length of the token
         * @param string[] $keys
         * @return string
         */
        public function generateToken(int $length = 32, array $keys = [self::DIGITS]):string {
            $this->initSymbols($keys);

            /**
             * Flipping the array solves two problems: 
             * 1. All repeating values are deleted because same keys overwrite each other
             * 2. array_rand can return the index and there is no need to build a statement like arr[array_rand(arr)]
             */
            $this->symbols = array_flip($this->symbols);
            $token         = "";

            for ($i = 0; $i < $length; $i++) {
                /**
                 * As the array is flipped, array_rand returns the symbol instead of its index
                 */
                $token .= array_rand($this->symbols);
            }

            return $token;
        }
    }