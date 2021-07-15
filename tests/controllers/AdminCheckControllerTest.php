<?php

namespace Tests\Controllers;

use Controllers\IController;
use Controllers\AdminCheckController;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Controllers\ProxyController
 */
class AdminCheckControllerTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::index
     *
     * @return void
     */
    public function testIndexInvokesInnerControllerMethod(): void
    {
        $origin = $this->getMockBuilder(IController::class)->getMock();
        $origin->expects($this->once())
        ->method("index");
        (new AdminCheckController($origin))->index();
    }
}
