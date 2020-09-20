<?php

    namespace Tests\Components;

    use Components\Router;
    use InvalidArgumentException;
    use LogicException;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing Router class
     * 
     * @coversDefaultClass Router
     */
    class RouterTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var Router
         */
        protected $router;

        /**
         * Set up required ROOT constant for 'run' method
         *
         * @return void
         */
        public static function setUpBeforeClass():void {
            define("ROOT", "/chem-proj/");
        }

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->router = $this->getMockBuilder(Router::class)
                                 ->onlyMethods(["invokeFactory"])
                                 ->getMock();
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->router = null;
        }

        /**
         * @covers ::run
         *
         * @return void
         */
        public function testRunThrowsInvalidArgumentExceptionOnEmptyInput():void {
            $this->expectException(InvalidArgumentException::class);

            $this->router->run();
        }

        public function testRunThrowsLogicExceptionOnEmptyInput():void {
            $this->expectException(LogicException::class);

            $this->router->run("http://localhost/chem-proj/addresses/list");
        }

        /**
         * @covers ::run
         * 
         * @dataProvider provideRoutes
         *
         * @return void
         */
        public function testRunSpeed(array $routes):void {
            $this->router->setRoutes($routes);
            /**
             * Contains domains for testing 'run' method
             * 
             * @var string[]
             */
            $domains      = ["addresses", "companies", "chemicals", "countries", "genders", "medicines", "purposes", "restricts"];
            $actions      = ["list", "add", "edit/1", "delete/1"];
            $currTime     = microtime(true);
            $domainLength = count($domains) - 1;
            $actionLength = count($actions) - 1;

            for ($i = 0; $i < 1000000; $i++) { 
                $this->router->run("http://localhost/chem-proj/" . $domains[mt_rand(0, $domainLength)] . "/" . $actions[mt_rand(0, $actionLength)]);
            }

            $currTime = microtime(true) - $currTime;

            $this->assertLessThan(1, $currTime);
        }

        /**
         * Provides routes for 'run' method
         *
         * @return string[][][][]
         */
        public function provideRoutes():array {
            return [
                [
                    array(
                        "AddressesFactory" => array(
                            "addresses/list"                  => "index",
                            "addresses/add"                   => "add",
                            "addresses/edit/([1-9][0-9]*$)"   => "edit",
                            "addresses/delete/([1-9][0-9]*$)" => "delete"
                        ),
                        "ChemicalsFactory" => array(
                            "chemicals/list"                  => "index",
                            "chemicals/add"                   => "add",
                            "chemicals/edit/([1-9][0-9]*$)"   => "edit",
                            "chemicals/delete/([1-9][0-9]*$)" => "delete"
                        ),
                        "CompaniesFactory" => array(
                            "companies/list"                  => "index",
                            "companies/add"                   => "add",
                            "companies/edit/([1-9][0-9]*$)"   => "edit",
                            "companies/delete/([1-9][0-9]*$)" => "delete"
                        ),
                        "CountriesFactory" => array(
                            "countries/list"                  => "index",
                            "countries/add"                   => "add",
                            "countries/edit/([1-9][0-9]*$)"   => "edit",
                            "countries/delete/([1-9][0-9]*$)" => "delete"
                        ),
                        "GendersFactory" => array(
                            "genders/list"                  => "index",
                            "genders/add"                   => "add",
                            "genders/edit/([1-9][0-9]*$)"   => "edit",
                            "genders/delete/([1-9][0-9]*$)" => "delete"
                        ),
                        "MedicinesFactory" => array(
                            "medicines/list"                  => "index",
                            "medicines/add"                   => "add",
                            "medicines/edit/([1-9][0-9]*$)"   => "edit",
                            "medicines/delete/([1-9][0-9]*$)" => "delete"
                        ),
                        "PurposesFactory" => array(
                            "purposes/list"                  => "index",
                            "purposes/add"                   => "add",
                            "purposes/edit/([1-9][0-9]*$)"   => "edit",
                            "purposes/delete/([1-9][0-9]*$)" => "delete"
                        ),
                        "RestrictsFactory" => array(
                            "restricts/list"                  => "index",
                            "restricts/add"                   => "add",
                            "restricts/edit/([1-9][0-9]*$)"   => "edit",
                            "restricts/delete/([1-9][0-9]*$)" => "delete"
                        ),
                        "UsersFactory" => array(
                            "users/list"      => "index",
                            "users/register"  => "register",
                            "users/authorise" => "authorise",
                            "users/logout"    => "logout"
                        )
                    )
                ]
            ];
        }

    }