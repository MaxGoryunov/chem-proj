<?php

namespace Components;

/**
 * Interface for scalar values.
 */
interface Scalar
{

    /**
     * Returns calculated value of this scalar.
     *
     * @return mixed
     */
    public function value(): mixed;
}
