<?php

    namespace Tests\Entities;

use Entities\AddressEntity;
use PHPUnit\Framework\TestCase;

    /**
     * Testing AddressEntity class
     * 
     * @coversDefaultClass AddressEntity
     */
    class AddressEntityTest extends TestCase {

        /**
         * @covers ::__get
         * @covers ::__set
         * 
         * @dataProvider providePropertiesAndValues
         *
         * @param string $property - property name
         * @param mixed $value     - property value
         * @param mixed $expected  - expected result
         * @return void
         */
        public function testSettingPrivatePropertyOnDifferentInputs(string $property, $value, $expected):void {
            $entity            = new AddressEntity();
            $entity->$property = $value;

            $this->assertEquals($expected, $entity->$property);
        }

        /**
         * @return (string|int|null)[][]
         */
        public function providePropertiesAndValues():array {
            return [
                "unsetProperty"   => ["wwww", "value", null],
                "tableColumnName" => ["address_id", 3, 3],
                "actualProperty"  => ["id", 4, null]
            ];
        }
    }