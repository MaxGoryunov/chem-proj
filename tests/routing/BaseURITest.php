<?php

namespace Tests\Routing;

use PHPUnit\Framework\TestCase;
use Routing\BaseURI;

/**
 * @coversDefaultClass Routing\BaseURI
 */
final class BaseURITest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::parted
     * 
     * @small
     *
     * @return void
     */
    public function testPartedReturnsSubparts(): void
    {
        $raw = "localhost/chem-proj/addresses/add";
        $this->assertEquals(
            explode("/", $raw),
            (new BaseURI($raw))->parted()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::parted
     * 
     * @small
     *
     * @return void
     */
    public function testPartedReturnsSubpartsWithBackslashes(): void
    {
        $raw = "localhost\\chem-proj\\countries\\edit\\14";
        $this->assertEquals(
            explode("\\", $raw),
            (new BaseURI($raw))->parted()
        );
    }
}
