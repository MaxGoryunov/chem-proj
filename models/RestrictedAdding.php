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
     * @param Adding   $origin  original adding model.
     * @param string[] $demands array of required fields.
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
        private array $demands
    ) {
    }

    /**
     * Only adds values if they all of values in demands are present in a
     * given array of data.
     * {@inheritDoc}
     * @throws RestrictionNotPassedException if some values are not present.
     */
    public function added(array $data): static
    {
        if (
            count(
                array_intersect(
                    array_keys($data),
                    $this->demands
                )
            ) !== count($this->demands)
        ) {
            throw new RestrictionNotPassedException(
                join(
                    "",
                    [
                        "Given data set [",
                        join(", ", $data),
                        "] does not contain values from list [",
                        join(", ", $this->demands),
                        "]"
                    ]
                )
            );
        }
        return new self($this->origin->added($data), $this->demands);
    }
}
