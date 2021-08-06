<?php

namespace Entities;

/**
 * Gender entity.
 */
interface Gender
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

    /**
     * Short name.
     *
     * @return string
     */
    public function shortName(): string;
}
