<?php

namespace Tests\Connections;

use Connections\BaseResult;
use Connections\MethodNotFoundException;
use mysqli_result;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @coversDefaultClass Connections\Result
 */
final class BaseResultTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::fetchAssoc
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
            (new BaseResult(
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
        (new BaseResult(new stdClass(), []))->fetchAssoc();
    }
}
