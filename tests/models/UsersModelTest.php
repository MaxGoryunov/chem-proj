<?php

    namespace Tests\Models;

    use Factories\AbstractMVCPDMFactory;
    use Models\UsersModel;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing UsersModel class
     * 
     * @coversDefaultClass Models\UsersModel
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
            $this->usersModel = new UsersModel("users", $this->getMockForAbstractClass(AbstractMVCPDMFactory::class));
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
         * @covers ::__construct
         * @covers ::getUserAdminStatus
         * 
         * @uses Components\DBServiceProvider
         * @uses Components\MySQLConnection
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\IQueryBuilder
         * @uses DBQueries\Query
         * @uses DBQueries\SelectQueryBuilder
         * @uses Models\AbstractModel
         * @uses Models\DomainModel
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
         * @covers ::__construct
         * @covers ::calculateRegisteredCount
         * 
         * @uses Components\DBServiceProvider
         * @uses Components\MySQLConnection
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\IQueryBuilder
         * @uses DBQueries\Query
         * @uses DBQueries\SelectQueryBuilder
         * @uses Models\AbstractModel
         * @uses Models\DomainModel
         * 
         * @dataProvider provideUserEmails
         *
         * @param string $login - user login
         * @param int $expected - expected result
         * @return void
         */
        public function testCalculateRegisteredCountReturnsCorrectValue(string $email, int $expected):void {
            $this->assertEquals($expected, $this->usersModel->calculateRegisteredCount($email));
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

        /**
         * Returns user emails
         *
         * @return (string|int)[][]
         */
        public function provideUserEmails():array {
            return [
                "registered"    => ["gormak@rr.rr", 1],
                "notRegistered" => ["nonexistent@gmail.ru", 0]
            ];
        }
    }