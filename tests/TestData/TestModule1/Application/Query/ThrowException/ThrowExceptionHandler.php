<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Query\ThrowException;

use App\Common\Application\Query\IQueryHandler;
use App\Tests\TestData\TestModule1\Application\MyCustomException;

class ThrowExceptionHandler implements IQueryHandler
{
    public function __construct()
    {
    }

    /**
     * @throws MyCustomException
     */
    public function __invoke(ThrowExceptionQuery $query): void
    {
        throw new MyCustomException();
    }
}
