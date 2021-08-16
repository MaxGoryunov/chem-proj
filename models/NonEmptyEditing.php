<?php

namespace Models;

use Models\Exceptions\EmptyDataException;

/**
 * Editing model which does not allow to add empty data.
 */
final class NonEmptyEditing implements Editing
{

    /**
     * Ctor.
     * 
     * @param Editing $origin original editing model.
     */
    public function __construct(
        /**
         * Original editing model.
         *
         * @var Editing
         */
        private Editing $origin
    ) {
    }

    /**
     * Does not edit values if data is empty.
     * {@inheritDoc}
     * @throws EmptyDataException if data is empty.
     */
    public function edited(array $data): static
    {
        if ($data === []) {
            throw new EmptyDataException(
                "Empty data given for edition in Editing model"
            );
        }
        return new self($this->origin->edited($data));
    }

    /**
     * {@inheritDoc}
     */
    public function entity(): object
    {
        return $this->origin->entity();
    }
}
