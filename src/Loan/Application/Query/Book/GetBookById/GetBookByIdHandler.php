<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Book\GetBookById;

use App\Common\Application\Query\IQueryHandler;

readonly class GetBookByIdHandler implements IQueryHandler
{
    public function __construct(private IGetBookById $repository)
    {
    }

    public function __invoke(GetBookByIdQuery $query): BookDto
    {
        return $this->repository->getBookById($query->id);
    }
}
