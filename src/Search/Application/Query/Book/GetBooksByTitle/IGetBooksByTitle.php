<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetBooksByTitle;

interface IGetBooksByTitle
{
    /**
     * @return array<BookDto>
     */
    public function getBooksByTitle(string $title): array;
}
