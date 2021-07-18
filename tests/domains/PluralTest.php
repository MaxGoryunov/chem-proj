<?php

namespace Tests\Domains;

use Domains\Plural;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Domains\Plural
 */
class PluralTest extends TestCase
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
    public function testReturnsDomainInPluralForm(): void
    {
        $this->assertEquals(
            "medicines",
            (new Plural("medicines", "tests\domains\domains"))->value()
        );
    }
}