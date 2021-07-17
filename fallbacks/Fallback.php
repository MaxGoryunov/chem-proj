<?php

namespace Fallbacks;

/**
 * Interface for actions executed when some condition is not met.
 */
interface Fallback
{

    /**
     * Executes action.
     *
     * @return mixed
     */
    public function call(): mixed;
}
