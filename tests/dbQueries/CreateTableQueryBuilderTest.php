<?php

    namespace Tests\DBQueries;

    use DBQueries\CreateTableQueryBuilder;
    use Components\TableColumn;
use DBQueries\IQuery;
use Models\AbstractModel;
use Models\IModel;
use PHPUnit\Framework\TestCase;

    /**
     * @coversDefaultClass DBQueries\CreateTableQueryBuilder
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
            $model = $this->getMockBuilder(IModel::class)
                            ->disableOriginalConstructor()
                            ->getMock();

            $model->method("getTableName")
                    ->willReturn("medicines");

            $this->builder = new CreateTableQueryBuilder($model);
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
         * @covers ::setColumns
         * @covers ::getQueryString
         * 
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * 
         * @small
         *
         * @return void
         */
        public function testSetColumnsCorrectlySetsColumns():void {
            $columns[] = (new TableColumn("id"))
                            ->setType("int", 10)
                            ->setNull(false)
                            ->setAutoIncrement(true)
                            ->setPrimaryKey(true);
            $columns[] = (new TableColumn("name"))
                            ->setType("varchar", 20);
            $columns[] = (new TableColumn("description"))
                            ->setType("text");

            $this->assertSame($this->builder, $this->builder->setColumns($columns));
            $this->assertEquals("CREATE TABLE `medicines` (`id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(20), `description` TEXT);", $this->builder->getQueryString());
        }

        /**
         * @covers ::column
         * 
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\CreateTableQueryBuilder
         * 
         * @dataProvider provideColumnNames
         * 
         * @small
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
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * 
         * @small
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
         * @covers ::column
         * @covers ::autoIncrement
         * @covers ::getCurrentColumn
         * 
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * 
         * @small
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
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\CreateTableQueryBuilder
         * 
         * @small
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
         * @covers ::int
         * 
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\CreateTableQueryBuilder
         * 
         * @small
         *
         * @return void
         */
        public function testIntSetsColumnTypeToInt():void {
            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("id")->int(10));
            $this->assertEquals("INT(10)", $this->builder->getCurrentColumn()->getType());
        }

        /**
         * @covers ::varchar
         * 
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\CreateTableQueryBuilder
         * 
         * @small
         *
         * @return void
         */
        public function testVarcharSetsColumnTypeToVarchar():void {
            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("name")->varchar(20));
            $this->assertEquals("VARCHAR(20)", $this->builder->getCurrentColumn()->getType());
        }

        /**
         * @covers ::text
         * 
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\CreateTableQueryBuilder
         * 
         * @small
         *
         * @return void
         */
        public function testTextSetsColumnTypeToText():void {
            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("description")->text());
            $this->assertEquals("TEXT", $this->builder->getCurrentColumn()->getType());
        }

        /**
         * @covers ::timestamp
         * 
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\CreateTableQueryBuilder
         * 
         * @small
         *
         * @return void
         */
        public function testTimestampSetsColumnTypeToTimestamp():void {
            $this->assertInstanceOf(CreateTableQueryBuilder::class, $this->builder->column("created_at")->timestamp());
            $this->assertEquals("TIMESTAMP", $this->builder->getCurrentColumn()->getType());
        }

        /**
         * @covers ::build
         * @covers ::getQueryString
         * 
         * @uses Components\TableColumn
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\CreateTableQueryBuilder
         * @uses DBQueries\Query
         * 
         * @small
         *
         * @return void
         */
        public function testBuildReturnsCorrectStatement():void {
            $this->builder->column("id")->int(10)->canBeNull(false)->autoIncrement(true)->isPrimaryKey(true)
                            ->column("name")->varchar("30")
                            ->column("description")->text();

            $query = $this->builder->build();

            $this->assertInstanceOf(IQuery::class, $query);
            $this->assertEquals("CREATE TABLE `medicines` (`id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(30), `description` TEXT);", $query->getQueryString());
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