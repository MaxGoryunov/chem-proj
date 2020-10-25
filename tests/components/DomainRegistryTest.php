<?php

    namespace Tests\Components;

    use Components\Domain;
    use Components\DomainRegistry;
    use OutOfRangeException;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing DomainRegistry class
     * 
     * @coversDefaultClass DomainRegistry
     */
    class DomainRegistryTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var DomainRegistry
         */
        protected $domainRegistry;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->domainRegistry = new DomainRegistry();
        }
        
        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->domainRegistry = null;
        }
        
        /**
         * @covers ::getDomain
         *
         * @return void
         */
        public function testGetDomainThrowsExceptionWhenDomainIsNotFound():void {
            $this->expectException(OutOfRangeException::class);

            $domain = $this->domainRegistry->getDomain("asd");
        }

        /**
         * @covers ::setDomainData
         * @covers ::getDomainData
         *
         * @return void
         */
        public function testSetDomainDataAcceptsDomainDataFromFile():void {
            $this->domainRegistry->setDomainData("./tests/components/domainData.php");

            $data = include("domainData.php");

            $this->assertEquals($data, $this->domainRegistry->getDomainData());
        }

        /**
         * @covers ::setDomainData
         * @covers ::getDomainData
         *
         * @return void
         */
        public function testDomainDataCanBeSetOnce():void {
            $this->domainRegistry->setDomainData("./tests/components/domainData.php");
            $this->domainRegistry->setDomainData("./tests/components/newDomainData.php");

            $data    = include("domainData.php");
            $newData = include("newDomainData.php");

            $this->assertSame($data, $this->domainRegistry->getDomainData());
            $this->assertNotSame($newData, $this->domainRegistry->getDomainData());
        }

        /**
         * @covers ::getDomain
         * 
         * @dataProvider provideDomainNames
         *
         * @param string $domainPlural      - domain name in plural
         * @param string $domainSingular    - domain name in singular
         * @param string $translation       - translated domain name
         * @param string $translationClause - translated domain name in clause
         * @return void
         */
        public function testGetDomainReturnsCorrectDomain(string $domainPlural, string $domainSingular, string $translation, string $translationClause):void {
            $this->domainRegistry->setDomainData("./tests/components/domainData.php");

            $domain = $this->domainRegistry->getDomain($domainPlural);

            $this->assertInstanceOf(Domain::class, $domain);
            $this->assertEquals($domainSingular, $domain->getDomainSingular());
            $this->assertEquals($translation, $domain->getTranslation());
            $this->assertEquals($translationClause, $domain->getTranslationClause());
        }

        /**
         * @return string[][]
         */
        public function provideDomainNames():array {
            return [
                "addresses" => ["addresses", "address", "адреса", "адреса"],
                "companies" => ["companies", "company", "компании", "компании"],
                "medicines" => ["medicines", "medicine", "препараты", "препарата"]
            ];
        }
    }