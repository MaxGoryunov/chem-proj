<?php

    namespace Tests\Components;

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

            $domain = DomainRegistry::getDomain("addresses");
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
        public function testSetDomainDataCanBeSetOnce():void {
            DomainRegistry::setDomainData("./tests/components/domainData.php");
            DomainRegistry::setDomainData("./tests/components/newDomainData.php");

            $data    = include("domainData.php");
            $newData = include("newDomainData.php");

            $this->assertSame($data, DomainRegistry::getDomainData());
            $this->assertNotSame($newData, DomainRegistry::getDomainData());
        }
    }