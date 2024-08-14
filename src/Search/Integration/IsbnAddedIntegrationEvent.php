<?php

declare(strict_types=1);

namespace App\Search\Integration;

use App\Common\Application\Event\IIntegrationEvent;

readonly class IsbnAddedIntegrationEvent implements IIntegrationEvent
{
    public function __construct(public string $isbn)
    {
    }
}
