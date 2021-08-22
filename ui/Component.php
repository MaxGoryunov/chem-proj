<?php

namespace UI;

/**
 * UI component.
 */
interface Component
{

    /**
     * Returns a rendered component.
     *
     * @return string
     */
    public function rendered(): string;
}
