<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\WillFail;

use App\Common\Application\Command\ICommandHandler;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Tests\TestData\TestModule1\Application\MyCustomException;
use App\Tests\TestData\TestModule1\Domain\Dummy\Dummy;
use App\Tests\TestData\TestModule1\Domain\Dummy\IDummyRepository;
use Exception;

class WillFailHandler implements ICommandHandler
{
    public function __construct(
        private IDummyRepository $repository,
        private IUuidGenerator $uuidGenerator
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(WillFailCommand $command): void
    {
        $first = Dummy::create($this->uuidGenerator);
        $this->repository->store($first);

        throw new MyCustomException();
    }
}
