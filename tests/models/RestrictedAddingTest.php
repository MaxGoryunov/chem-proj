<?php

namespace Tests\Models;

use Models\Adding;
use Models\RestrictedAdding;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Models\RestrictedAdding
 */
final class RestrictedAddingTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::added
     * 
     * @small
     *
     * @return void
     */
    public function testCallsOriginIfRequiredValuesAreGiven(): void
    {
        $origin = $this->createMock(Adding::class);
        $origin->expects($this->once())->method("added")->willReturn($origin);
        (new RestrictedAdding(
            $origin,
            ["name", "email", "address"]
        ))
            ->added(
                [
                    "name"    => "Susie",
                    "email"   => "susie@work.com",
                    "address" => "LA"
                ]
            );
    }

    // /**
    //  * @covers ::__construct
    //  * @covers ::added
    //  * 
    //  * @small
    //  *
    //  * @return void
    //  */
    // public function testThrowsExceptionIfSomeValuesAreNotInTheGivenDataArray(): void
    // {
    //     $this->expectException(RestrictionNotPassedException::class);
    // }
}
