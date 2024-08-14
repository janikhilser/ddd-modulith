<?php

declare(strict_types=1);

namespace App\Search\Infrastructure\Persistence\Specification;

use App\Common\Infrastructure\Persistence\DoctrineQueries;
use App\Search\Domain\Book\Book;
use App\Search\Domain\Book\Exception\IsbnAlreadyExistsException;
use App\Search\Domain\Book\Specification\IUniqueIsbnSpecification;
use App\Search\Domain\Book\ValueObject\Isbn;
use App\Search\Infrastructure\Configuration\Module;

final class UniqueIsbnSpecification extends DoctrineQueries implements IUniqueIsbnSpecification
{
    /**
     * @throws IsbnAlreadyExistsException
     */
    public function isUnique(Isbn $isbn): bool
    {
        if ($this->isbnExists($isbn->getIsbn())) {
            throw new IsbnAlreadyExistsException('A book with the ISBN "'.$isbn->getIsbn().'" already exists.');
        }

        return true;
    }

    public function isbnExists(string $isbn): bool
    {
        $builder = $this->getNewQueryBuilder();

        $builder
            ->select('b')
            ->from(Book::class, 'b')
            ->innerJoin('b.isbns', 'i')
            ->where('i.isbn = :isbn')
            ->setParameter('isbn', $isbn);

        $result = $builder->getQuery()->getResult();

        return !empty($result);
    }

    protected function getModuleName(): string
    {
        return Module::NAME;
    }
}
