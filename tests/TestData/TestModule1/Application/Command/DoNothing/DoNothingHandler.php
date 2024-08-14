<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\DoNothing;

use App\Common\Application\Command\ICommandHandler;

class DoNothingHandler implements ICommandHandler
{
    public function __construct()
    {
    }

    public function __invoke(DoNothingCommand $command): string
    {
        return 'test-id';
    }
}
