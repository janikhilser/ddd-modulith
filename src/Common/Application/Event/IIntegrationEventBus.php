<?php

declare(strict_types=1);

namespace App\Common\Application\Event;

use Throwable;

interface IIntegrationEventBus
{
    /**
     * @throws Throwable
     */
    public function publish(IIntegrationEvent $event): void;
}
