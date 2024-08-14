<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\DomainEventHandler;

use App\Common\Application\Event\IDomainEventHandler;
use App\Tests\TestData\TestModule1\Application\MyCustomException;
use App\Tests\TestData\TestModule1\Domain\Dummy\DomainEvent\DummyCreated;

class DummyCreatedHandler implements IDomainEventHandler
{
    /**
     * @throws MyCustomException
     */
    public function __invoke(DummyCreated $event): void
    {
        throw new MyCustomException();
    }
}
