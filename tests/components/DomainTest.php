<?php

    namespace Tests\Components;

    use Components\Domain;
    use InvalidArgumentException;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing Domain class
     * 
     * @coversDefaultClass Domain
     */
    class DomainTest extends TestCase {

        /**
         * Creates tested class mock object
         * 
         * Due to the fact that the creation of the mock is similar in different methods it was extracted in a separate function
         *
         * @return Domain
         */
        protected function setUpMock():Domain {
            /**
             * @var Domain
             */
            $domain = $this->getMockBuilder(Domain::class)
                      ->disableOriginalConstructor()
                      ->onlyMethods([])
                      ->getMock();

            return $domain;
        }

        /**
         * @covers ::getDomainPlural
         * 
         * @dataProvider provideDomainsPlural
         * 
         * @small
         *
         * @param string $domainPlural
         * @return void
         */
        public function testGetDomainPluralReturnsCorrectValue(string $domainPlural):void {
            $domain = new Domain($domainPlural);

            $this->assertEquals($domainPlural, $domain->getDomainPlural());
        }

        /**
         * @covers ::setDomainSingular
         * @covers ::getDomainSingular
         * 
         * @dataProvider provideDomainsSingular
         * 
         * @small
         *
         * @param string $domainSingular
         * @return void
         */
        public function testGetDomainSingularReturnsCorrectValue(string $domainSingular):void {
            $domain = $this->setUpMock();

            $this->assertInstanceOf(Domain::class, $domain->setDomainSingular($domainSingular));
            $this->assertEquals($domainSingular, $domain->getDomainSingular());
        }

        /**
         * @covers ::setTranslation
         * @covers ::getTranslation
         * 
         * @dataProvider provideTranslations
         * 
         * @small
         *
         * @param string[] $translation
         * @return void
         */
        public function testGetTranslationReturnsCorrectValue(array $translation):void {
            $domain = $this->setUpMock();

            $this->assertInstanceOf(Domain::class, $domain->setTranslation(...$translation));
            $this->assertEquals($translation[0], $domain->getTranslation());
        }

        /**
         * @covers ::setTranslation
         * @covers ::getTranslationClause
         * 
         * @dataProvider provideTranslations
         * 
         * @small
         *
         * @param string[] $translation
         * @return void
         */
        public function testSetTranslationClauseReturnsCorrectValue(array $translation):void {
            $domain = $this->setUpMock();

            $this->assertInstanceOf(Domain::class, $domain->setTranslation(...$translation));
            $this->assertEquals($translation[1], $domain->getTranslationClause());
        }

        /**
         * @covers ::setTranslation
         * 
         * @dataProvider provideEmptyTranslations
         * 
         * @small
         *
         * @param array $translation
         * @return void
         */
        public function testGetTranslationThrowsExceptionOnEmptyInput(array $translation):void {
            $this->expectException(InvalidArgumentException::class);

            $domain = $this->setUpMock();

            $domain->setTranslation(...$translation);
        }

        /**
         * Provides domains for testing 'getDomainPlural'
         *
         * @return string[][]
         */
        public function provideDomainsPlural():array {
            return [
                "addresses" => ["addresses"],
                "medicines" => ["medicines"],
                "connects"  => ["connect"]
            ];
        }

        /**
         * Provides domains for testing 'getDomainSingular'
         *
         * @return string[][]
         */
        public function provideDomainsSingular():array {
            return [
                "addresses" => ["address"],
                "medicines" => ["medicine"],
                "connects"  => ["connect"]
            ];
        }

        /**
         * Provides factory names for testing 'getFactoryName'
         *
         * @return string[][]
         */
        public function provideFactoryNames():array {
            return [
                "addresses" => ["AddressesFactory"],
                "medicines" => ["MedicinesFactory"],
                "connects"  => ["ConnectsFactory"]
            ];
        }

        /**
         * Provides translations for testing 'getTranslation' and 'getTranslationClause'
         *
         * @return string[][]
         */
        public function provideTranslations():array {
            return [
                "addresses" => [["адреса", "адреса"]],
                "medicines" => [["препараты", "препарата"]]
            ];
        }

        /**
         * Provides empty translations for testing 'setTranslation'
         *
         * @return string[][]
         */
        public function provideEmptyTranslations():array {
            return [
                "emptyTranslation"       => [["", "адреса"]],
                "emptyTranslationClause" => [["адреса", ""]]
            ];
        }
    }