<?php

namespace Tests\Models\Exceptions;

use Exception;
use Models\Exceptions\EmptyDataException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Models\Exceptions\EmptyDataException
 */
final class EmptyDataExceptionTest extends TestCase
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
            "Given data is empty",
            1,
            new Exception()
        ];
        $e = new EmptyDataException(...$data);
        $this->assertEquals(
            $data,
            [
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            ]
        );
    }
}
