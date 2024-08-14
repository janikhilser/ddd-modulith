<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Persistence;

use App\Common\Domain\Aggregate\Aggregate;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineAggregateRepository extends DoctrineQueries
{
    protected function persist(Aggregate $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();
    }

    protected function remove(Aggregate $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    /**
     * @template T of object
     *
     * @psalm-param class-string<T> $entityClass
     *
     * @psalm-return T
     *
     * @throws AggregateNotFoundException
     */
    protected function get(string $entityClass, string $id): object
    {
        $entity = $this->repository($entityClass)->find($id);

        if (empty($entity)) {
            throw new AggregateNotFoundException("Aggregate '$entityClass' with id '$id' not found");
        }

        return $entity;
    }

    /**
     * @template T of object
     *
     * @psalm-param class-string<T> $entityClass
     *
     * @psalm-return EntityRepository<T>
     */
    protected function repository(string $entityClass): EntityRepository
    {
        return $this->entityManager()->getRepository($entityClass);
    }
}
