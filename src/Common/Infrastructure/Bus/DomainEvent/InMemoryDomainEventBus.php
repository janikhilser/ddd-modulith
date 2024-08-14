<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\DomainEvent;

use App\Common\Application\Event\IDomainEventBus;
use App\Common\Domain\Aggregate\IDomainEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

class InMemoryDomainEventBus implements IDomainEventBus
{
    public function __construct(private readonly MessageBusInterface $domainEventBus)
    {
    }

    /**
     * @throws Throwable
     */
    public function publish(IDomainEvent $event): void
    {
        try {
            $this->domainEventBus->dispatch($event);
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }
    }
}
