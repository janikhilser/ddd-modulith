<?php

declare(strict_types=1);

namespace App\Search\Domain\Book\Repository;

use App\Search\Domain\Book\Book;
use App\Search\Domain\Book\ValueObject\BookId;

interface IBookRepository
{
    public function store(Book $book): void;

    public function load(BookId $bookId): Book;
}
