<?php

declare(strict_types=1);

namespace App\Search\Infrastructure\Persistence\Query;

use App\Common\Infrastructure\Persistence\DoctrineQueries;
use App\Search\Application\Query\Book\GetBookById\BookDto;
use App\Search\Application\Query\Book\GetBookById\IGetBookById;
use App\Search\Application\Query\Book\GetBooks\IGetBooks;
use App\Search\Application\Query\Book\GetBooksByTitle\IGetBooksByTitle;
use App\Search\Application\Query\Book\GetIdByIsbn\IGetIdByIsbn;
use App\Search\Domain\Book\Book;
use App\Search\Domain\Book\ValueObject\BookId;
use App\Search\Domain\Book\ValueObject\Isbn;
use App\Search\Infrastructure\Configuration\Module;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class BookQueries extends DoctrineQueries implements IGetBooksByTitle, IGetBooks, IGetBookById, IGetIdByIsbn
{
    public function getBooksByTitle(string $title): array
    {
        $builder = $this->getNewQueryBuilder();

        $builder
            ->select(
                sprintf(
                    'NEW %s(b.id, b.title.title)',
                    \App\Search\Application\Query\Book\GetBooksByTitle\BookDto::class
                )
            )
            ->from(Book::class, 'b')
            ->where('b.title.title LIKE :searchString')
            ->setParameter('searchString', '%'.$title.'%');

        return $builder->getQuery()->getResult();
    }

    public function getBooks(): array
    {
        $builder = $this->getNewQueryBuilder();

        $builder
            ->select(
                sprintf(
                    'NEW %s(b.id, b.title.title)',
                    \App\Search\Application\Query\Book\GetBooks\BookDto::class
                )
            )
            ->from(Book::class, 'b');

        return $builder->getQuery()->getResult();
    }

    /**
     * @throws NoResultException
     */
    public function getBookById(BookId $id): BookDto
    {
        $builder = $this->getNewQueryBuilder();
        $buchRows = $builder
            ->select('b.id, b.title.title', 'i.isbn')
            ->from(Book::class, 'b')
            ->leftJoin('b.isbns', 'i')
            ->where('b.id = :id')
            ->setParameter('id', $id)->getQuery()->getArrayResult();

        if (empty($buchRows)) {
            throw new NoResultException();
        }

        $isbns = [];
        foreach ($buchRows as $buchRow) {
            if (empty($buchRow['isbn'])) {
                continue;
            }
            $isbns[] = $buchRow['isbn'];
        }

        return new BookDto($buchRows[0]['id']->getId(), $buchRows[0]['title.title'], $isbns);
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getIdByIsbn(Isbn $isbn): BookId
    {
        $bookId = $this->getNewQueryBuilder()
            ->select('b.id')
            ->from(Book::class, 'b')
            ->innerJoin('b.isbns', 'i')
            ->where('i.isbn = :isbn')
            ->setParameter('isbn', $isbn->getIsbn())
            ->getQuery()
            ->getSingleResult();

        return BookId::fromString($bookId['id']->getId());
    }

    protected function getModuleName(): string
    {
        return Module::NAME;
    }
}
