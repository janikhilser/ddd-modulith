<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Domain\Dummy\DomainEvent;

use App\Common\Domain\Aggregate\IDomainEvent;

readonly class DummyCreatedMultipleHandler implements IDomainEvent
{
    public function __construct()
    {
    }
}
