<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetBooks;

interface IGetBooks
{
    /**
     * @return array<BookDto>
     */
    public function getBooks(): array;
}
