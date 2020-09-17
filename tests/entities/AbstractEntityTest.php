<?php

    namespace Tests\Entities;

    use Entities\AbstractEntity;
    use PHPUnit\Framework\TestCase;

    /**
     * Testing AbstractEntity class
     * 
     * @coversDefaultClass AbstractEntity
     */
    class AbstractEntityTest extends TestCase {

        /**
         * @covers ::getId
         * 
         * @dataProvider provideIds
         *
         * @param int $id
         * @return void
         */
        public function testGetIdReturnsEntityId(int $id):void {
            $entity = $this->getMockForAbstractClass(AbstractEntity::class, [$id]);

            $this->assertEquals($id, $entity->getId());
        }

        public function provideIds():array {
            return [
                "zero"        => [0],
                "positive"    => [4],
                "bigPositive" => [1000000]
            ];
        }
    }