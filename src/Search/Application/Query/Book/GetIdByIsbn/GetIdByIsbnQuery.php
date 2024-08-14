<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetIdByIsbn;

use App\Common\Application\Query\IQuery;
use App\Common\Domain\Assertion\AssertionFailedException;
use App\Search\Domain\Book\ValueObject\Isbn;

readonly class GetIdByIsbnQuery implements IQuery
{
    public Isbn $isbn;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $isbn)
    {
        $this->isbn = Isbn::fromString($isbn);
    }
}
