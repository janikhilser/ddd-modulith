<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Query\Default;

use App\Common\Application\Query\IQueryHandler;

class DefaultHandler implements IQueryHandler
{
    public function __construct()
    {
    }

    /**
     * @return array<string>
     */
    public function __invoke(DefaultQuery $query): array
    {
        return ['result'];
    }
}
