<?php

namespace Tests\Models;

use Models\Editing;
use Models\Exceptions\RestrictionNotPassedException;
use Models\RestrictedEditing;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Models\RestrictedEditing
 */
final class RestrictedEditingTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::edited
     * 
     * @small
     *
     * @return void
     */
    public function testCallsOriginIfDataIsCorrect(): void
    {
        $origin = $this->createMock(Editing::class);
        $origin->expects($this->once())->method("edited")->willReturn($origin);
        (new RestrictedEditing($origin, ["name", "email", "address"]))
            ->edited(
                [
                    "name"    => "Andrew",
                    "address" => "Monaco",
                    "email"   => "and@rew.com"
                ]
            );
    }

    /**
     * @covers ::__construct
     * @covers ::edited
     * 
     * @small
     *
     * @return void
     */
    public function testThrowsExceptionIfDataIsIncorrect(): void
    {
        $this->expectException(RestrictionNotPassedException::class);
        (new RestrictedEditing(
            $this->createMock(Editing::class),
            ["name", "email", "address"]
        ))
            ->edited(
                [
                    "name" => "Sonia",
                    "address" => "Kazan"
                ]
            );
    }
}
