<?php

namespace Tests\Components;

use Components\CurrentPage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Components\CurrentPage
 */
final class CurrentPageTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::value
     * 
     * @small
     *
     * @return void
     */
    public function testReturnsCorrectNumberOfPages(): void
    {
        $this->assertEquals(
            4,
            (new CurrentPage(
                "localhost/chem-proj/countries/list?q=str&page=4&offset=7"
            ))->value()
        );
    }
}
