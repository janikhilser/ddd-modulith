<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Query;

use App\Common\Application\Query\IQuery;
use App\Common\Application\Query\IQueryBus;
use App\Common\Infrastructure\Bus\NoHandlerException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final class InMemoryQueryBus implements IQueryBus
{
    public function __construct(private readonly MessageBusInterface $queryBus)
    {
    }

    /**
     * @throws Throwable
     */
    public function ask(IQuery $query): mixed
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->queryBus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException) {
            throw new NoHandlerException(sprintf('The query has not a valid handler: %s', $query::class));
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }
    }
}
