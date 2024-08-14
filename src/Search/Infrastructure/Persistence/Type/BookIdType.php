<?php

declare(strict_types=1);

namespace App\Search\Infrastructure\Persistence\Type;

use App\Common\Infrastructure\Persistence\UuidType;
use App\Search\Domain\Book\ValueObject\BookId;

class BookIdType extends UuidType
{
    public const BOOK_ID = 'search_book_id';

    public function getName(): string
    {
        return static::BOOK_ID;
    }

    protected function getValueObjectClassName(): string
    {
        return BookId::class;
    }
}
