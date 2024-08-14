<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetIdByIsbn;

use App\Common\Application\Query\IQueryHandler;
use App\Search\Domain\Book\ValueObject\BookId;

final readonly class GetIdByIsbnHandler implements IQueryHandler
{
    public function __construct(private IGetIdByIsbn $repository)
    {
    }

    public function __invoke(GetIdByIsbnQuery $query): BookId
    {
        return $this->repository->getIdByIsbn($query->isbn);
    }
}
