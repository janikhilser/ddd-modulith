<?php

declare(strict_types=1);

namespace App\Common\Application\Query;

interface IQueryBus
{
    public function ask(IQuery $query): mixed;
}
