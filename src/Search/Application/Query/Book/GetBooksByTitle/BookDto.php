<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetBooksByTitle;

readonly class BookDto
{
    public function __construct(public string $id, public string $title)
    {
    }
}
