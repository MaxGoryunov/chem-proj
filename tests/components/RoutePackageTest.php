<?php

    namespace Tests\Components;

    use Components\RoutePackage;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

    /**
     * Testing RoutePackage class
     * 
     * @coversDefaultClass RoutePackage
     */
    class RoutePackageTest extends TestCase {

        /**
         * @covers ::getDomain
         * 
         * @dataProvider provideDomainsAndFactories
         *
         * @param string $domain
         * @param string $factory
         * @return void
         */
        public function testGetDomainReturnsSuppliedString(string $domain, string $factory):void {
            $package = new RoutePackage($domain, $factory);

            $this->assertEquals($domain, $package->getDomain());
        }

        /**
         * @covers ::__construct
         *
         * @return void
         */
        public function testGetDomainThrowsExceptionOnEmptyInput():void {
            $this->expectException(InvalidArgumentException::class);

            $package = new RoutePackage("", "AddressesFactory");
        }

        /**
         * @covers ::getFactory
         * 
         * @dataProvider provideDomainsAndFactories
         *
         * @param string $domain
         * @param string $factory
         * @return void
         */
        public function testGetFactoryReturnsSuppliedString(string $domain, string $factory):void {
            $package = new RoutePackage($domain, $factory);

            $this->assertEquals($factory, $package->getFactory());
        }

        /**
         * @covers ::__construct
         *
         * @return void
         */
        public function testGetFactoryThrowsExceptionOnEmptyInput():void {
            $this->expectException(InvalidArgumentException::class);

            $package = new RoutePackage("addresses", "");
        }

        /**
         * @covers ::addRoute
         * @covers ::getActionByRoute
         * 
         * @dataProvider provideActions
         *
         * @param string $route - route pattern
         * @param string $action - corresponding action
         * @param string $getRoute - actual route
         * @param array $expected - expected result
         * @return void
         */
        public function testAddRouteAddsRouteToRoutesArray(string $route, string $action, string $getRoute, array $expected):void {
            $package = new RoutePackage("addresses", "AddressesFactory");

            $package->addRoute($route, $action);

            $this->assertEquals($expected, $package->getActionByRoute($getRoute));
        }

        /**
         * Returns strings for 'getDomain' and 'getFactory' methods
         *
         * @return string[][]
         */
        public function provideDomainsAndFactories():array {
            return [
                ["addresses", "AddressesFactory"],
                ["medicines", "MedicinesFactory"],
                ["users", "UsersFactory"]
            ];
        }

        /**
         * Returns actions for 'addRoute' and 'getActionByRoute' methods
         *
         * @return string[][]
         */
        public function provideActions():array {
            return [
                "list"   => ["list", "index", "list", ["id" => null, "action" => "index"]],
                "edit"   => ["edit/([1-9][0-9]*$)", "edit", "edit/11", ["id" => 11, "action" => "edit"]],
                "add"    => ["add", "add", "add", ["id" => null, "action" => "add"]],
                "delete" => ["delete/([1-9][0-9]*$)", "delete", "delete/11", ["id" => 11, "action" => "delete"]]
            ];
        }
    }