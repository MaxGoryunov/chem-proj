<?php

namespace Tests\Connections;

use Connections\MethodNotFoundException;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Connections\MethodNotFoundException
 */
final class MethodNotFoundExceptionTest extends TestCase
{

    /**
     * @covers ::__construct
     * 
     * @uses Exception
     * 
     * @small
     *
     * @return void
     */
    public function testCallsParentCtor(): void
    {
        $data = [
            "This method was not found",
            1,
            new Exception()
        ];
        $e = new MethodNotFoundException(...$data);
        $this->assertEquals(
            $data,
            [$e->getMessage(), $e->getCode(), $e->getPrevious()]
        );
    }
}
