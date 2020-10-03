<?php

    namespace Tests\Traits;

    use PHPUnit\Framework\TestCase;
    use ReflectionClass;
    use Traits\TableNameTrait;

    /**
     * Testing TableNameTrait trait
     * 
     * @coversDefaultClass TableNameTrait
     */
    class TableNameTraitTest extends TestCase {

        /**
         * @covers ::getTableName
         * 
         * @dataProvider provideTableNames
         *
         * @param string $tableName
         * @return void
         */
        public function testGetTableNameReturnsCorrectValue(string $tableName):void {
            $traitClass        = new class { use TableNameTrait; };
            $reflection        = new ReflectionClass($traitClass);
            $getTableName      = $reflection->getMethod("getTableName");
            $tableNameProperty = $reflection->getProperty("tableName");

            $getTableName->setAccessible(true);
            $tableNameProperty->setAccessible(true);
            $tableNameProperty->setValue($traitClass, $tableName);

            $this->assertEquals($tableName, $getTableName->invoke($traitClass));
        }

        /**
         * Provides table names for testing 'getTableName'
         *
         * @return string[][]
         */
        public function provideTableNames():array {
            return [
                "addresses" => ["addresses"],
                "medicines" => ["medicines"],
                "companies" => ["companies"]
            ];
        }
    }