<?php

namespace Entities;

/**
 * Address entity.
 */
interface Address
{

    /**
     * Id.
     *
     * @return int
     */
    public function id(): int;

    /**
     * Name.
     *
     * @return string
     */
    public function name(): string;
}
