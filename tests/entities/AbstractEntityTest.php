<?php

    namespace Tests\Entities;

use Entities\AbstractEntity;
use PHPUnit\Framework\TestCase;

    /**
     * @coversDefaultClass Entities\AbstractEntity
     */
    class AbstractEntityTest extends TestCase {

        /**
         * @covers ::__set
         * @covers ::__get
         * @covers ::snakeToCamelCase
         *
         * @return void
         */
        public function testSetSnakeCasePropertySetsCorrectProperty():void {
            $entity = new class extends AbstractEntity {
                public $className;
                public $longProperty;

                protected function getType():string {
                    return "Entity";
                }
            };

            $checks[] = "name";
            $checks[] = "value";

            $entity->class_name    = $checks[0];
            $entity->long_property = $checks[1];

            $this->assertEquals($checks[0], $entity->className);
            $this->assertEquals($checks[1], $entity->longProperty);
        }
    }