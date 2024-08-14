<?php

declare(strict_types=1);

namespace App\Search\Domain\Book\Specification;

use App\Search\Domain\Book\Exception\IsbnAlreadyExistsException;
use App\Search\Domain\Book\ValueObject\Isbn;

interface IUniqueIsbnSpecification
{
    /**
     * @throws IsbnAlreadyExistsException
     */
    public function isUnique(Isbn $isbn): bool;
}
