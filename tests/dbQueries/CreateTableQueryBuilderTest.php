<?php

    namespace Tests\DBQueries;

    use DBQueries\CreateTableQueryBuilder;
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
            $this->assertEquals([], $this->builder->getCurrentColumn());
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

            $this->assertEquals("YES", $this->builder->getCurrentColumn()["Null"]);

            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_name")->canBeNull(false));

            $this->assertEquals("NO", $this->builder->getCurrentColumn()["Null"]);
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

            $this->assertEquals("auto_increment", $this->builder->getCurrentColumn()["Extra"]);

            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_id")->autoIncrement(false));

            $this->assertEquals("", $this->builder->getCurrentColumn()["Extra"]);
        }

        /**
         * @covers ::isPrimaryKey
         *
         * @return void
         */
        public function testIsPrimaryKeyMakesTheColumnPrimary():void {
            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_id")->isPrimaryKey(true));

            $this->assertEquals("primary key", $this->builder->getCurrentColumn()["Primary"]);

            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_name")->isPrimaryKey(true));
            
            $this->assertEquals("primary key", $this->builder->getCurrentColumn()["Primary"]);

            $this->builder->column("address_id");
            $this->assertEquals("", $this->builder->getCurrentColumn()["Primary"]);

            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("address_name")->isPrimaryKey(false));

            $this->assertEquals("", $this->builder->getCurrentColumn()["Primary"]);
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