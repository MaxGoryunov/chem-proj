<?php

namespace Models;

use Models\Exceptions\RestrictionNotPassedException;

/**
 * Adding model which only adds values if all of them are present in a
 * predefined list.
 */
final class RestrictedAdding implements Adding
{

    /**
     * Ctor.
     * 
     * @param Adding $origin       original adding model.
     * @param array  $restrictions array of required fields.
     */
    public function __construct(
        /**
         * Original adding model.
         *
         * @var Adding
         */
        private Adding $origin,

        /**
         * Array of required fields.
         *
         * @var string[]
         */
        private array $restrictions
    ) {
    }

    /**
     * Only adds values if they all of values in restrictions are present in a
     * given array of data.
     * {@inheritDoc}
     */
    public function added(array $data): static
    {
        if (
            array_intersect(
                array_keys($data),
                $this->restrictions
            ) !== $this->restrictions
        ) {
            throw new RestrictionNotPassedException(
                join(
                    "",
                    [
                        "Given data set [",
                        join(", ", $data),
                        "] does not contain values from list [",
                        join(", ", $this->restrictions),
                        "]"
                    ]
                )
            );
        }
        return new self($this->origin->added($data), $this->restrictions);
    }
}
