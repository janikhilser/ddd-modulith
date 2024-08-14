<?php

declare(strict_types=1);

namespace App\Loan\Infrastructure\Persistence\Repository;

use App\Common\Infrastructure\Persistence\AggregateNotFoundException;
use App\Common\Infrastructure\Persistence\DoctrineAggregateRepository;
use App\Loan\Domain\Book\Book;
use App\Loan\Domain\Book\Repository\IBookRepository;
use App\Loan\Domain\Book\ValueObject\BookId;
use App\Loan\Infrastructure\Configuration\Module;

class BookRepository extends DoctrineAggregateRepository implements IBookRepository
{
    public function store(Book $book): void
    {
        $this->persist($book);
    }

    /**
     * @throws AggregateNotFoundException
     */
    public function load(BookId $bookId): Book
    {
        return $this->get(Book::class, $bookId->getId());
    }

    protected function getModuleName(): string
    {
        return Module::NAME;
    }
}
