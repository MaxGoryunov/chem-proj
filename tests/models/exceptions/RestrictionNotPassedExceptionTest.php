<?php

namespace Tests\Models\Exceptions;

use Exception;
use Models\Exceptions\RestrictionNotPassedException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Models\Exceptions\RestrictionNotPassedException
 */
final class RestrictionNotPassedExceptionTest extends TestCase
{

    /**
     * @covers ::__construct
     * 
     * @small
     *
     * @return void
     */
    public function testCallsParentCtor(): void
    {
        $input = [
            "restriction in module did not pass",
            3,
            $this->createMock(Exception::class)
        ];
        $e = new RestrictionNotPassedException(...$input);
        $this->assertEquals(
            $input,
            [
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            ]
        );
    }
}
