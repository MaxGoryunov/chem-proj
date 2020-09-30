<?php

    namespace Tests\Models;

    use Factories\AbstractMVCPDMFactory;
    use Models\UsersModel;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing UsersModel class
     * 
     * @coversDefaultClass UsersModel
     */
    class UsersModelTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var UsersModel
         */
        protected $usersModel;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->usersModel = new UsersModel($this->getMockForAbstractClass(AbstractMVCPDMFactory::class));
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->usersModel = null;
        }

        /**
         * @covers ::getUserAdminStatus
         * 
         * @dataProvider provideUserIds
         *
         * @param int $id
         * @return void
         */
        public function testGetUserAdminStatusReturnsCorrectValue(int $id, bool $expected):void {
            $this->assertEquals($expected, $this->usersModel->getUserAdminStatus($id));
        }

        /**
         * Returns user Ids 
         *
         * @return (int|bool)[][]
         */
        public function provideUserIds():array {
            return [
                "none"         => [0, false],
                "regular user" => [3, false],
                "admin"        => [12, true]
            ];
        }
    }