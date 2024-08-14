<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetBooksByTitle;

use App\Common\Application\Query\IQueryHandler;

final readonly class GetBooksByTitleHandler implements IQueryHandler
{
    public function __construct(private IGetBooksByTitle $repository)
    {
    }

    /**
     * @return array<BookDto>
     */
    public function __invoke(GetBooksByTitleQuery $query): array
    {
        return $this->repository->getBooksByTitle($query->title->toString());
    }
}
