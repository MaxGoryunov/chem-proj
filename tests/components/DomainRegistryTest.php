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
         * @covers ::getDomain
         *
         * @return void
         */
        public function testGetDomainThrowsExceptionWhenDomainIsNotFound():void {
            $this->expectException(OutOfRangeException::class);

            $domain = DomainRegistry::getDomain("asd");
        }

        /**
         * @covers ::setDomainData
         * @covers ::getDomainData
         *
         * @return void
         */
        public function testSetDomainDataAcceptsDomainDataFromFile():void {
            DomainRegistry::setDomainData("./tests/components/domainData.php");

            $data = include("domainData.php");

            $this->assertEquals($data, DomainRegistry::getDomainData());
        }

        /**
         * @covers ::setDomainData
         * @covers ::getDomainData
         *
         * @return void
         */
        public function testDomainDataCanBeSetOnce():void {
            DomainRegistry::setDomainData("./tests/components/domainData.php");
            DomainRegistry::setDomainData("./tests/components/newDomainData.php");

            $data    = include("domainData.php");
            $newData = include("newDomainData.php");

            $this->assertSame($data, DomainRegistry::getDomainData());
            $this->assertNotSame($newData, DomainRegistry::getDomainData());
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
            DomainRegistry::setDomainData("./tests/components/domainData.php");

            $domain = DomainRegistry::getDomain($domainPlural);

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