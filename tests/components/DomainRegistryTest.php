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
        public function testRegistryAcceptsDomainDataFromFile():void {
            DomainRegistry::setDomainData("domainData.php");

            $data = include_once("domainData.php");

            $this->assertEquals($data, DomainRegistry::getDomainData());
        }
    }