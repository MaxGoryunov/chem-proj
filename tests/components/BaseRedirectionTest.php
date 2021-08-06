<?php

namespace Tests\Components;

use Components\BaseRedirection;
use Connections\MethodNotFoundException;
use mysqli_result;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @coversDefaultClass Components\BaseRedirection
 */
final class BaseRedirectionTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::__call
     * 
     * @small
     *
     * @return void
     */
    public function testReturnsInvokedMethodResult(): void
    {
        $input = [
            "id"    => "12",
            "name"  => "John",
            "email" => "john@example.com"
        ];
        $origin = $this->getMockBuilder(mysqli_result::class)
        ->disableOriginalConstructor()
        ->getMock();
        $origin->method("fetch_assoc")->willReturn($input);
        $this->assertEquals(
            $input,
            (new BaseRedirection(
                $origin,
                ["fetchAssoc" => "fetch_assoc"]
            ))->fetchAssoc()
        );
    }

    /**
     * @covers ::__construct
     * 
     * @small
     *
     * @return void
     */
    public function testFailsIfMethodIsNotFound(): void
    {
        $this->expectException(MethodNotFoundException::class);
        (new BaseRedirection(new stdClass(), []))->fetchAssoc();
    }
}
