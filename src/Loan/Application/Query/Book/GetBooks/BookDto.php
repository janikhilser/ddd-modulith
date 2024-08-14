<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Book\GetBooks;

readonly class BookDto
{
    public function __construct(
        public string $id,
        public int $countOfLoans
    ) {
    }
}
