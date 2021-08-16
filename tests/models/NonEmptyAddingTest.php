<?php

namespace Tests\Models;

use Models\Adding;
use Models\Exceptions\EmptyDataException;
use Models\NonEmptyAdding;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Models\NonEmptyAdding
 */
final class NonEmptyAddingTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::added
     * 
     * @small
     *
     * @return void
     */
    public function testCallsOriginMethodIfDataIsNotEmpty(): void
    {
        $origin = $this->createMock(Adding::class);
        $origin->expects($this->once())->method("added")->willReturn($origin);
        (new NonEmptyAdding($origin))->added(["id" => 142]);
    }

    /**
     * @covers ::__construct
     * @covers ::added
     * 
     * @small
     *
     * @return void
     */
    public function testThrowsExceptionIfDataIsEmpty(): void
    {
        $this->expectException(EmptyDataException::class);
        (new NonEmptyAdding($this->createMock(Adding::class)))->added([]);
    }
}
