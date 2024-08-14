<?php

declare(strict_types=1);

namespace App\Loan\Infrastructure\Persistence\Query;

use App\Common\Infrastructure\Persistence\DoctrineQueries;
use App\Loan\Application\Query\Book\GetBookById\BookDto;
use App\Loan\Application\Query\Book\GetBookById\BookNotFoundException;
use App\Loan\Application\Query\Book\GetBookById\IGetBookById;
use App\Loan\Application\Query\Book\GetBookById\LoanDto;
use App\Loan\Application\Query\Book\GetBooks\IGetBooks;
use App\Loan\Domain\Book\Book;
use App\Loan\Domain\Publication\Publication;
use App\Loan\Infrastructure\Configuration\Module;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;

class BookQueries extends DoctrineQueries implements IGetBooks, IGetBookById
{
    public function getBooks(): array
    {
        $builder = $this->getNewQueryBuilder();

        $builder
            ->select(
                sprintf(
                    'NEW %s(b.id, COUNT(l.id))',
                    \App\Loan\Application\Query\Book\GetBooks\BookDto::class
                )
            )
            ->from(Book::class, 'b')
            ->leftJoin('b.loans', 'l')
            ->groupBy('b.id');

        return $builder->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws BookNotFoundException
     */
    public function getBookById(string $id): BookDto
    {
        $builder = $this->getNewQueryBuilder();
        $builder
            ->select('b.id', 'p.isbn.isbn')
            ->from(Book::class, 'b')
            ->innerJoin(Publication::class, 'p', Join::WITH, 'b.publicationId = p.id')
            ->where('b.id = :id')
            ->setParameter('id', $id);

        try {
            $book = $builder->getQuery()->getSingleResult();
        } catch (NoResultException) {
            throw new BookNotFoundException();
        }

        $builder = $this->getNewQueryBuilder();
        $builder
            ->select(
                sprintf(
                    'NEW %s(l.sequence, l.returned)',
                    LoanDto::class
                )
            )
            ->from(Book::class, 'b')
            ->innerJoin('b.loans', 'l')
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->orderBy('l.sequence');

        $loans = $builder->getQuery()->getResult();

        return new BookDto($book['id']->getId(), $book['isbn.isbn'], $loans);
    }

    protected function getModuleName(): string
    {
        return Module::NAME;
    }
}
