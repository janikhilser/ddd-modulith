<?php

declare(strict_types=1);

namespace App\Common\Application\Event;

use App\Common\Domain\Aggregate\IDomainEvent;

interface IDomainEventBus
{
    public function publish(IDomainEvent $event): void;
}
