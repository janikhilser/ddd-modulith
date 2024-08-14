<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\RaiseDomainEvent;

use App\Common\Application\Command\ICommandHandler;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Tests\TestData\TestModule1\Domain\Dummy\Dummy;
use App\Tests\TestData\TestModule1\Domain\Dummy\IDummyRepository;

class RaiseDomainEventHandler implements ICommandHandler
{
    public function __construct(
        private IDummyRepository $repository,
        private IUuidGenerator $uuidGenerator
    ) {
    }

    public function __invoke(RaiseDomainEventCommand $command): void
    {
        $first = Dummy::createWithEvent($this->uuidGenerator);

        if ($command->persist) {
            $this->repository->store($first);
        }
    }
}
