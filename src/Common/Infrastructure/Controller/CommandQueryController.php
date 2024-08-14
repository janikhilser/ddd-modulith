<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Controller;

use App\Common\Application\Command\ICommand;
use App\Common\Application\Command\ICommandBus;
use App\Common\Application\Query\IQuery;
use App\Common\Application\Query\IQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Throwable;

abstract class CommandQueryController extends AbstractController
{
    public function __construct(
        private readonly ICommandBus $commandBus,
        private readonly IQueryBus $queryBus
    ) {
    }

    /**
     * @throws Throwable
     */
    protected function handle(ICommand $command): ?string
    {
        return $this->commandBus->handle($command);
    }

    /**
     * @throws Throwable
     */
    protected function ask(IQuery $query): mixed
    {
        return $this->queryBus->ask($query);
    }
}
