<?php

namespace Models;

use Models\Exceptions\RestrictionNotPassedException;

/**
 * Editing model which restricts editing values if some of them are not
 * present.
 */
final class RestrictedEditing implements Editing
{

    /**
     * Ctor.
     * 
     * @param Editing  $origin  original model.
     * @param string[] $demands values which must be present.
     */
    public function __construct(
        /**
         * Original model.
         *
         * @var Editing
         */
        private Editing $origin,

        /**
         * Values which must be in data array.
         *
         * @var string[]
         */
        private array $demands
    ) {
    }

    /**
     * Only edits values if all values from demands are present.
     * {@inheritDoc}
     * @throws RestrictionNotPassedException if some value is not present.
     */
    public function edited(array $data): static
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
                        join(", ", array_keys($data)),
                        "] does not contain values from list [",
                        join(", ", $this->demands),
                        "]"
                    ]
                )
            );
        }
        return new self($this->origin->edited($data), $this->demands);
    }

    /**
     * {@inheritDoc}
     */
    public function entity(): object
    {
        return $this->origin->entity();
    }
}
