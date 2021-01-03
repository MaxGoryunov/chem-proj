<?php

    namespace Tests\DBQueries;

    use DBQueries\CreateTableQueryBuilder;
use DBQueries\TableColumn;
use PHPUnit\Framework\TestCase;

    /**
     * @coversDefaultClass CreateTableQueryBuilder
     */
    class CreateTableQueryBuilderTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var CreateTableQueryBuilder
         */
        protected $builder;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->builder = new CreateTableQueryBuilder("medicines");
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->builder = null;
        }

        /**
         * @covers ::column
         * 
         * @dataProvider provideColumnNames
         *
         * @return void
         */
        public function testColumnSetsUpColumnName(string $columnName):void {
            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column($columnName));
            $this->assertEquals($columnName, $this->builder->getCurrentColumnName());
            $this->assertInstanceOf(TableColumn::class, $this->builder->getCurrentColumn());
        }

        /**
         * @covers ::column
         * @covers ::canBeNull
         * @covers ::getCurrentColumn
         *
         * @return void
         */
        public function testCanBeNullSetsNullPropertyOfColumn():void {
            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_name")->canBeNull(true));

            $this->assertEquals("", $this->builder->getCurrentColumn()->getNull());

            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_name")->canBeNull(false));

            $this->assertEquals("NOT NULL", $this->builder->getCurrentColumn()->getNull());
        }

        /**
         * @covers ::getTableDescription
         * @covers ::column
         * @covers ::autoIncrement
         * @covers ::getCurrentColumn
         *
         * @return void
         */
        public function testAutoIncrementSetsExtraPropertyOfColumn():void {
            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_id")->autoIncrement(true));

            $this->assertEquals("AUTO_INCREMENT", $this->builder->getCurrentColumn()->getAutoIncrement());

            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_id")->autoIncrement(false));

            $this->assertEquals("", $this->builder->getCurrentColumn()->getAutoIncrement());
        }

        /**
         * @covers ::isPrimaryKey
         *
         * @return void
         */
        public function testIsPrimaryKeyMakesTheColumnPrimary():void {
            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_id")->isPrimaryKey(true));

            $this->assertEquals("PRIMARY KEY", $this->builder->getCurrentColumn()->getPrimaryKey());

            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_name")->isPrimaryKey(true));
            
            $this->assertEquals("PRIMARY KEY", $this->builder->getCurrentColumn()->getPrimaryKey());

            $this->builder->column("address_id");
            $this->assertEquals("", $this->builder->getCurrentColumn()->getPrimaryKey());

            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_name")->isPrimaryKey(false));

            $this->assertEquals("", $this->builder->getCurrentColumn()->getPrimaryKey());
        }

        /**
         * @return string[][]
         */
        public function provideColumnNames():array {
            return [
                ["address_id"],
                ["address_name"],
                ["medicine_name"]
            ];
        }
    }