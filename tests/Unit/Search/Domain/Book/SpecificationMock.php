<?php

declare(strict_types=1);

namespace App\Tests\Unit\Search\Domain\Book;

use App\Search\Domain\Book\Specification\IUniqueIsbnSpecification;
use App\Search\Domain\Book\ValueObject\Isbn;

class SpecificationMock implements IUniqueIsbnSpecification
{
    public function isUnique(Isbn $isbn): bool
    {
        return true;
    }
}
