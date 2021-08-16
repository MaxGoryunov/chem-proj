<?php

namespace Tests\Models;

use Models\Editing;
use Models\Exceptions\EmptyDataException;
use Models\NonEmptyEditing;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Models\NonEmptyEditing
 */
final class NonEmptyEditingTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::edited
     * 
     * @small
     *
     * @return void
     */
    public function testCallsOriginMethodIfDataIsNotEmpty(): void
    {
        $origin = $this->createMock(Editing::class);
        $origin->expects($this->once())->method("edited")->willReturn($origin);
        (new NonEmptyEditing($origin))->edited(["name" => "Bob"]);
    }

    /**
     * @covers ::__construct
     * @covers ::edited
     * 
     * @small
     *
     * @return void
     */
    public function testThrowsExceptionIfDataIsEmpty(): void
    {
        $this->expectException(EmptyDataException::class);
        (new NonEmptyEditing($this->createMock(Editing::class)))->edited([]);
    }
}
