<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetBookById;

use App\Search\Domain\Book\ValueObject\BookId;

interface IGetBookById
{
    public function getBookById(BookId $id): BookDto;
}
