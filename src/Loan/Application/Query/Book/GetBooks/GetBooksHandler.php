<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Book\GetBooks;

use App\Common\Application\Query\IQueryHandler;

readonly class GetBooksHandler implements IQueryHandler
{
    public function __construct(private IGetBooks $repository)
    {
    }

    /**
     * @return array<BookDto>
     */
    public function __invoke(GetBooksQuery $query): array
    {
        return $this->repository->getBooks();
    }
}
