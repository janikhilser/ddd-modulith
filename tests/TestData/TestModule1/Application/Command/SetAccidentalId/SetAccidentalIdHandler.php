<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\SetAccidentalId;

use App\Common\Application\Command\ICommandHandler;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Tests\TestData\TestModule1\Domain\Dummy\Dummy;
use App\Tests\TestData\TestModule1\Domain\Dummy\IDummyRepository;

readonly class SetAccidentalIdHandler implements ICommandHandler
{
    public function __construct(private IDummyRepository $repository, private IUuidGenerator $uuidGenerator)
    {
    }

    public function __invoke(SetAccidentalIdCommand $command): string
    {
        $dummy = Dummy::create($this->uuidGenerator);
        $dummy->setAccidentalId($command->id);
        $this->repository->store($dummy);

        return $dummy->getId();
    }
}
