<?php

    namespace Tests\Models;

    use Models\ConnectsModel;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing ConnectsModel class
     * 
     * @coversDefaultClass ConnectsModel
     */
    class ConnectsModelTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var ConnectsModel
         */
        protected $connectsModel;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->connectsModel = new ConnectsModel();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->connectsModel = null;
        }

        /**
         * @covers ::getUserAuthStatus
         * 
         * @dataProvider provideUserIdsTokensAndSessionIds
         *
         * @param int $userId - id of the user to be checked
         * @param string $token - unique string which assures user's authorisation
         * @param string $sessionId - session id unique per user
         * @param bool $expected
         * @return void
         */
        public function testGetUserAuthStatusReturnsCorrectValue(int $userId, string $token, string $sessionId, bool $expected):void {
            $this->assertEquals($expected, $this->connectsModel->getUserAuthStatus($userId, $token, $sessionId));
        }

        /**
         * Provides user IDs, tokens and session ids for testing
         *
         * @return (int|string|bool)[][]
         */
        public function provideUserIdsTokensAndSessionIds():array {
            return [
                "notConnected" => [3, "bdds796ffulbok13f8u50n15sgta8bkm", "f8clgn5bm3l4id7trt349j458g", false],
                "connected"    => [12, "bdds796phfybok1cobu50n15vosh8bkm", "fhclgn5bm3l4il7titp89j458g", true]
            ];
        }
    }