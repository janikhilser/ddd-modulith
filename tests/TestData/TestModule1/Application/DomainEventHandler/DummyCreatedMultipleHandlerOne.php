<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\DomainEventHandler;

use App\Common\Application\Event\IDomainEventHandler;
use App\Tests\TestData\TestModule1\Domain\Dummy\DomainEvent\DummyCreatedMultipleHandler;

class DummyCreatedMultipleHandlerOne implements IDomainEventHandler
{
    public function __invoke(DummyCreatedMultipleHandler $event): void
    {
        echo 'DummyCreatedMultipleHandlerOne';
    }
}
