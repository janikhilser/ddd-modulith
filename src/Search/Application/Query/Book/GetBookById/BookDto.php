<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetBookById;

readonly class BookDto
{
    /**
     * @param array<string> $isbns
     */
    public function __construct(public string $id, public string $title, public array $isbns)
    {
    }
}
