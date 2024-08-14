<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Book\GetBookById;

use App\Common\Application\Query\IQuery;

readonly class GetBookByIdQuery implements IQuery
{
    public function __construct(public string $id)
    {
    }
}
