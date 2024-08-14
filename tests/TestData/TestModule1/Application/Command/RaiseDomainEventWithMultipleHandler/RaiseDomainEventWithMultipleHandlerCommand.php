<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\RaiseDomainEventWithMultipleHandler;

use App\Common\Application\Command\ICommand;

class RaiseDomainEventWithMultipleHandlerCommand implements ICommand
{
    public function __construct()
    {
    }
}
