<?php

declare(strict_types=1);

namespace App\Loan\Infrastructure\Persistence\Query;

use App\Common\Infrastructure\Persistence\DoctrineQueries;
use App\Loan\Application\Command\Book\Buy\IGetIdByIsbn;
use App\Loan\Application\Query\Publication\GetPublications\IGetPublication;
use App\Loan\Application\Query\Publication\GetPublications\PublicationDto;
use App\Loan\Domain\Publication\Publication;
use App\Loan\Infrastructure\Configuration\Module;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class PublicationQueries extends DoctrineQueries implements IGetPublication, IGetIdByIsbn
{
    public function getPublication(): array
    {
        $builder = $this->getNewQueryBuilder();

        $builder
            ->select(
                sprintf(
                    'NEW %s(p.id, p.isbn.isbn)',
                    PublicationDto::class
                )
            )
            ->from(Publication::class, 'p');

        return $builder->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getIdByIsbn(string $isbn): string
    {
        $builder = $this->getNewQueryBuilder();

        $builder
            ->select('p.id')
            ->from(Publication::class, 'p')
            ->where('p.isbn.isbn = :isbn')
            ->setParameter('isbn', $isbn);

        return $builder->getQuery()->getSingleResult()['id']->getId();
    }

    protected function getModuleName(): string
    {
        return Module::NAME;
    }
}
