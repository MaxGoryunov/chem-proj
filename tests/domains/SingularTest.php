<?php

namespace Tests\Domains;

use Domains\Singular;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Domains\Singular
 */
class SingularTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::value
     * 
     * @uses Domains\FormEnvelope
     * 
     * @small
     *
     * @return void
     */
    public function testReturnsDomainInSingularForm(): void
    {
        $this->assertEquals(
            "country",
            (new Singular("countries", "tests/domains/domains"))->value()
        );
    }
}
