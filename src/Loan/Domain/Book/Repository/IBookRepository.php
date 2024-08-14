<?php

declare(strict_types=1);

namespace App\Loan\Domain\Book\Repository;

use App\Loan\Domain\Book\Book;
use App\Loan\Domain\Book\ValueObject\BookId;

interface IBookRepository
{
    public function store(Book $book): void;

    public function load(BookId $bookId): Book;
}
