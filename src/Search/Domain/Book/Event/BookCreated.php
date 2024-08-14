<?php

declare(strict_types=1);

namespace App\Search\Domain\Book\Event;

use App\Common\Domain\Aggregate\IDomainEvent;
use App\Search\Domain\Book\ValueObject\Isbn;

readonly class BookCreated implements IDomainEvent
{
    /**
     * @param array<Isbn> $isbns
     */
    public function __construct(public array $isbns)
    {
    }
}
