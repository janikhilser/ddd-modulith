<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Book\GetBooks;

interface IGetBooks
{
    /**
     * @return array<BookDto>
     */
    public function getBooks(): array;
}
