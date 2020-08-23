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
         * The initialization of the symbols is done in Lazy Load manner so that the array is not created during the creation of the object
         *
         * @return void
         */
        private function initSymbols():void {
            if (empty($this->symbols)) {
                $this->symbols = array_merge(range(0, 9), range("a", "z"));
                $this->length  = count($this->symbols);
            }
        }
        /**
         * Function returns a token, user can specify the token length if needed
         *
         * @param integer $length - length of the token
         * @return string
         */
        public function generateToken(int $length = 32):string {
            $token = "";

            for ($i = 0; $i < $length; $i++) {
                /**
                 * One is subtracted from Length in order to avoid LengthException
                 */
                $this->token .= $this->symbols[mt_rand(0, $this->length - 1)];
            }

            return $this->token;
        }
    }