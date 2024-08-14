<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Command;

use App\Common\Application\Command\ICommand;
use App\Common\Application\Command\ICommandBus;
use App\Common\Infrastructure\Bus\NoHandlerException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final readonly class InMemoryCommandBus implements ICommandBus
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @throws Throwable
     */
    public function handle(ICommand $command): ?string
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->commandBus->dispatch($command)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException) {
            throw new NoHandlerException(sprintf('The command has not a valid handler: %s', $command::class));
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }
    }
}
