<?php

namespace Models;

use Models\Exceptions\EmptyDataException;

/**
 * Does not allow to add empty data.
 */
final class NonEmptyAdding implements Adding
{

    /**
     * Ctor.
     * 
     * @param Adding $origin original adding model.
     */
    public function __construct(
        /**
         * Original adding model.
         * 
         * @var Adding
         */
        private Adding $origin
    ) {
    }

    /**
     * Does not add values if data is empty.
     * {@inheritDoc}
     * @throws EmptyDataException if data is empty.
     */
    public function added(array $data): static
    {
        if ($data === []) {
            throw new EmptyDataException(
                "Empty data given for addition in Adding model"
            );
        }
        return new self($this->origin->added($data));
    }
}