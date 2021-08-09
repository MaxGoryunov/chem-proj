<?php

namespace Tests\Fakes;

use Fakes\MysqliResult;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Fakes\FakeMysqliResult
 */
final class MysqliResultTest extends TestCase
{

    /**
     * @covers ::__construct
     *
     * @return void
     */
    public function testReturnsDummyData(): void
    {
        $input = [
            "id"    => 13,
            "name"  => "Emily",
            "email" => "emily@example.com"
        ];
        $this->assertEquals(
            $input,
            (new MysqliResult(
                [
                    "fetch_assoc" => $input
                ]
            ))->fetch_assoc()
        );
    }
}
