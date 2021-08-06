<?php

namespace Entities;

/**
 * User status entity.
 */
interface UserStatus
{

    /**
     * Id.
     *
     * @return int
     */
    public function id(): int;

    /**
     * User status name.
     *
     * @return string
     */
    public function name(): string;
}
