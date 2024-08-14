<?php

declare(strict_types=1);

namespace App\Loan\Application\IntegrationEventHandler;

use App\Common\Application\Command\ICommandBus;
use App\Common\Application\Event\IIntegrationEventHandler;
use App\Common\Domain\Assertion\AssertionFailedException;
use App\Loan\Application\Command\Publication\Publish\PublishPublicationCommand;
use App\Search\Integration\IsbnAddedIntegrationEvent;

readonly class PublishPublication implements IIntegrationEventHandler
{
    public function __construct(private ICommandBus $commandBus)
    {
    }

    /**
     * @throws AssertionFailedException
     */
    public function __invoke(IsbnAddedIntegrationEvent $event): void
    {
        $this->commandBus->handle(new PublishPublicationCommand($event->isbn));
    }
}
