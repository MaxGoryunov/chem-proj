<?php

    namespace Tests\DBQueries;

    use Models\AbstractModel;
    use DBQueries\UpdateQueryBuilder;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing UpdateQueryBuilder
     * 
     * @coversDefaultClass \DBQueries\UpdateQueryBuilder
     */
    class UpdateQueryBuilderTest extends TestCase {

        /**
         * Contains tested class object
         *
         * @var UpdateQueryBuilder
         */
        protected $updateBuilder;

        /**
         * Creates tested class object
         *
         * @return void
         */
        protected function setUp():void {
            $model = $this->getMockBuilder(AbstractModel::class)
                            ->setConstructorArgs(["medicines"])
                            ->getMock();

            $this->updateBuilder = new UpdateQueryBuilder($model);
        }

        /**
         * Removes tested class object
         *
         * @return void
         */
        protected function tearDown():void {
            $this->updateBuilder = null;
        }

        /**
         * @covers ::getQueryString
         * @covers ::build
         * 
         * @uses DBQueries\AbstractQueryBuilder
         * @uses DBQueries\Query
         * @uses Traits\LimitTrait
         * @uses Traits\SetTrait
         * @uses Traits\WhereTrait
         * 
         * @return void
         */
        public function testBuildBuildsCorrectStatement():void {
            $query = $this->updateBuilder->set([
                        "medicine_name"  => "Sensu Bean",
                        "medicine_price" => 760,
                        "medicine_doze"  => 50
                    ])
                     ->where("`medicine_id` = 1")
                     ->or("`medicine_id` = 3")
                     ->limit(4)
                     ->build();

            $this->assertEquals(" UPDATE `medicines` SET `medicine_name` = 'Sensu Bean', `medicine_price` = '760', `medicine_doze` = '50' WHERE 1 AND `medicine_id` = 1 OR `medicine_id` = 3 LIMIT 4; ", preg_replace("/\s+/", " ", preg_replace("/\n/", " ", $query->getQueryString())));

        }
    }