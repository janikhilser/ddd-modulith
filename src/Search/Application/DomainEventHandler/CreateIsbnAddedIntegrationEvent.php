<?php

declare(strict_types=1);

namespace App\Search\Application\DomainEventHandler;

use App\Common\Application\Event\IDomainEventHandler;
use App\Common\Application\Event\IIntegrationEventBus;
use App\Search\Domain\Book\Event\BookCreated;
use App\Search\Domain\Book\Event\IsbnAdded;
use App\Search\Integration\IsbnAddedIntegrationEvent;

readonly class CreateIsbnAddedIntegrationEvent implements IDomainEventHandler
{
    public function __construct(private IIntegrationEventBus $integrationEventBus)
    {
    }

    public function __invoke(BookCreated|IsbnAdded $event): void
    {
        if ($event instanceof IsbnAdded) {
            $this->integrationEventBus->publish(new IsbnAddedIntegrationEvent($event->isbn->getIsbn()));

            return;
        }

        foreach ($event->isbns as $isbn) {
            $this->integrationEventBus->publish(new IsbnAddedIntegrationEvent($isbn->getIsbn()));
        }
    }
}
