<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\RaiseDomainEventWithNoHandler;

use App\Common\Application\Command\ICommandHandler;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Tests\TestData\TestModule1\Domain\Dummy\Dummy;
use App\Tests\TestData\TestModule1\Domain\Dummy\IDummyRepository;

class RaiseDomainEventWithNoHandlerHandler implements ICommandHandler
{
    public function __construct(
        private IDummyRepository $repository,
        private IUuidGenerator $uuidGenerator
    ) {
    }

    public function __invoke(RaiseDomainEventWithNoHandlerCommand $command): void
    {
        $first = Dummy::createWithEventNoHandler($this->uuidGenerator);

        $this->repository->store($first);
    }
}
