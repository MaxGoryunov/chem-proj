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
         * key for generating only token with symbols from [A-Z] range
         * 
         * @var string[]
         */
        public const LETTERS_UPPERCASE = ["AZ"];

        /**
         * Key for generating only token with symbols from [0-9a-Z] range
         * 
         * @var string[]
         */
        public const ALL = ["09", "az", "AZ"];

        /**
         * Initiated ranges which can be used for generating tokens
         *
         * @var array
         */
        private $ranges = [];

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
        public function getSymbols(array $keys):array {
            $requiredRanges = [];

            foreach ($keys as $ranges) {
                $rangeKey = $this->getKey($ranges);

                /**
                 * If the range is empty then the is is created from smaller ranges
                 */
                if (!isset($this->ranges[$rangeKey])) {
                    $generatedRanges = [];

                    foreach ($ranges as $range) {
                        $generatedRanges[] = range(...str_split($range));
                    }

                    $this->ranges[$rangeKey] = array_flip(array_merge(...$generatedRanges));
                }

                $requiredRanges[] = $this->ranges[$rangeKey];
            }

            return array_merge(...$requiredRanges);
        }

        /**
         * Function returns a token, user can specify the token length if needed
         *
         * @param int $length - length of the token
         * @param string[] $keys
         * @return string
         */
        public function generateToken(int $length = 32, array $keys = [self::ALL]):string {
            $symbols = $this->getSymbols($keys);
            $token   = "";

            for ($i = 0; $i < $length; $i++) {
                /**
                 * As the array is flipped, array_rand returns the symbol instead of its index
                 */
                $token .= array_rand($symbols);
            }

            return $token;
        }

        /**
         * Returns a unique token
         *
         * @return string
         */
        public function generateUniqueToken():string {
            return md5("" . microtime(true));
        }
    }