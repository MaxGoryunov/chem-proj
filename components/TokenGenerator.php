<?php

    /**
     * Class for creating tokens. Will be used later to create tokens for user connections
     */
    class TokenGenerator {
        /**
         * Symbols used to create a token
         *
         * @var string[]
         */
        private $symbols = [];
        /**
         * Length of the symbols array
         * 
         * @var int
         */
        private $length;

        /**
         * Controls creation of symbols used in tokens
         * 
         * The initialization of the symbols is done in Lazy Load manner so that the array is not created during the creation of the object
         *
         * @return int
         */
        public function initSymbols():int {
            if (empty($this->symbols)) {
                $this->symbols = array_merge(range(0, 9), range("a", "z"), range("A", "Z"));
                $this->length  = count($this->symbols);
            }

            return $this->length;
        }
        /**
         * Function returns a token, user can specify the token length if needed
         *
         * @param int $length - length of the token
         * @return string
         */
        public function generateToken(int $length = 32):string {
            $this->initSymbols();

            $token = "";

            for ($i = 0; $i < $length; $i++) {
                /**
                 * One is subtracted from Length in order to avoid LengthException
                 */
                $token .= $this->symbols[mt_rand(0, $this->length - 1)];
            }

            return $token;
        }
    }