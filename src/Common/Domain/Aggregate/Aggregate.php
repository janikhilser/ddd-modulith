<?php

declare(strict_types=1);

namespace App\Common\Domain\Aggregate;

use App\Common\Domain\Entity\IEntity;

abstract class Aggregate implements IEntity
{
    /**
     * @var IDomainEvent[]
     */
    private array $events = [];

    abstract public function getId(): string;

    /**
     * @return IDomainEvent[]
     */
    public function popEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    protected function raise(IDomainEvent $event): void
    {
        $this->events[] = $event;
    }
}
