<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\RaiseDomainEvent;

use App\Common\Application\Command\ICommand;

class RaiseDomainEventCommand implements ICommand
{
    public function __construct(public bool $persist = true)
    {
    }
}
