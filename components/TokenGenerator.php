<?php

    namespace Components;
    
    /**
     * Class for creating tokens. Will be used later to create tokens for user connections
     */
    class TokenGenerator {

        /**
         * Key for generating only token with symbols from [0-9] range
         * 
         * @var string
         */
        public const DIGITS = "digits";

        /**
         * Key for generating only token with symbols from [a-Z] range
         */
        public const LETTERS = "letters";

        /**
         * Symbols used to create a token
         *
         * @var string[]
         */
        private $symbols = [];

        /**
         * Controls creation of symbols used in tokens
         * 
         * The resulting array depends on the keys supplied in $keys variable and may include digits, letters or both digits and letters.
         *
         * @param string[] $keys
         * @return (int|string)[]
         */
        public function initSymbols(array $keys):array {
            if (in_array(self::DIGITS, $keys)) {
                $this->symbols = array_merge($this->symbols, range(0, 9));
            }
            
            if (in_array(self::LETTERS, $keys)) {
                $this->symbols = array_merge($this->symbols, array_merge(range("a", "z"), range("A", "Z")));
            }

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