<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\IntegrationEvent;

use App\Common\Application\Event\IIntegrationEvent;
use App\Common\Application\Event\IIntegrationEventBus;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

#[WithMonologChannel('integration')]
readonly class InMemoryIntegrationEventBus implements IIntegrationEventBus
{
    public function __construct(private MessageBusInterface $integrationEventBus, private LoggerInterface $logger)
    {
    }

    public function publish(IIntegrationEvent $event): void
    {
        try {
            $this->integrationEventBus->dispatch($event);
        } catch (NoHandlerForMessageException $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        } catch (Throwable $throwable) {
            $this->logger->critical($throwable->getMessage());
            throw $throwable;
        }
    }
}
