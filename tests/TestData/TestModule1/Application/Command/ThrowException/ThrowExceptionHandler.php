<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\ThrowException;

use App\Common\Application\Command\ICommandHandler;
use App\Tests\TestData\TestModule1\Application\MyCustomException;
use Exception;

class ThrowExceptionHandler implements ICommandHandler
{
    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ThrowExceptionCommand $command): void
    {
        throw new MyCustomException();
    }
}
