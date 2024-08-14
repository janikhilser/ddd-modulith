<?php

declare(strict_types=1);

namespace App\Search\Domain\Book\Event;

use App\Common\Domain\Aggregate\IDomainEvent;
use App\Search\Domain\Book\ValueObject\Isbn;

readonly class IsbnAdded implements IDomainEvent
{
    public function __construct(public Isbn $isbn)
    {
    }
}
