<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\RaiseDomainEventWithNoHandler;

use App\Common\Application\Command\ICommand;

class RaiseDomainEventWithNoHandlerCommand implements ICommand
{
    public function __construct()
    {
    }
}
