<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetBookById;

use App\Common\Application\Query\IQuery;
use App\Search\Domain\Book\ValueObject\BookId;

readonly class GetBookByIdQuery implements IQuery
{
    public BookId $id;

    public function __construct(string $id)
    {
        $this->id = BookId::fromString($id);
    }
}
