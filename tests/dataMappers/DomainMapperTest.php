<?php

    namespace Tests\DataMappers;

use DataMappers\DomainMapper;
use DBQueries\IQuery;
use DBQueries\SelectQueryBuilder;
use Entities\IEntity;
use PHPUnit\Framework\TestCase;

    /**
     * @coversDefaultClass DataMappers\DomainMapper
     */
    class DomainMapperTest extends TestCase {

        /**
         * @covers ::mapQueryResultToEntity
         * 
         * @dataProvider provideDomains
         * 
         * @small
         * 
         * @runInSeparateProcess
         *
         * @param string $domain   - domain name
         * @param string $singular - domain name in singular form
         * @return void
         */
        public function testMapQueryResultToEntityReturnsCorrectEntity(string $domain, string $singular):void {
            $mapper  = new DomainMapper($domain);
            $builder = $this->getMockBuilder(SelectQueryBuilder::class)
                            ->disableOriginalConstructor()
                            ->getMock();
            $query   = $this->getMockBuilder(IQuery::class)
                            ->getMock();
            
            $builder->expects($this->once())
                    ->method("build")
                    ->willReturn($query);
            $query->expects($this->once())
                    ->method("getQueryString")
                    ->willReturn("SELECT * FROM `$domain` WHERE `{$singular}_id` = 1;");

            $this->assertInstanceOf(IEntity::class, $mapper->mapQueryResultToEntity($builder));
        }


        public function provideDomains():array {
            return [
                ["addresses", "address"],
                ["genders", "gender"]
            ];
        }
    }