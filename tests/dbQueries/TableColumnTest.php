<?php

    namespace Tests\DBQueries;

    use DBQueries\TableColumn;
    use PHPUnit\Framework\TestCase;

    /**
     * @coversDefaultClass TableColumn
     */
    class TableColumnTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var TableColumn
         */
        protected $column;

        /**
         * Create tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $this->column = new TableColumn("name");
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->column = null;
        }

        /**
         * @covers ::getNull
         * @covers ::setNull
         *
         * @return void
         */
        public function testSetNullSetsNullValue():void {
            $this->column->setNull(true);
            $this->assertEquals("", $this->column->getNull());

            $this->column->setNull(false);
            $this->assertEquals("NOT NULL", $this->column->getNull());
        }

        /**
         * @covers ::getAutoIncrement
         * @covers ::setAutoIncrement
         *
         * @return void
         */
        public function testSetAutoIncrementSetsAutoIncrementValue():void {
            $this->column->setAutoIncrement(true);
            $this->assertEquals("AUTO_INCREMENT", $this->column->getAutoIncrement());

            $this->column->setAutoIncrement(false);
            $this->assertEquals("", $this->column->getAutoIncrement());
        }

        /**
         * @covers ::getPrimaryKey
         * @covers ::setPrimaryKey
         *
         * @return void
         */
        public function testSetPrimaryKeySetsPrimaryKeyValue():void {
            $this->column->setPrimaryKey(true);
            $this->assertEquals("PRIMARY KEY", $this->column->getPrimaryKey());

            $this->column->setPrimaryKey(false);
            $this->assertEquals("", $this->column->getPrimaryKey());
        }
    }