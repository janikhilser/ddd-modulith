<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use TypeError;

abstract class DoctrineQueries
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    public function getNewQueryBuilder(): QueryBuilder
    {
        return $this->entityManager()->createQueryBuilder();
    }

    protected function entityManager(): EntityManagerInterface
    {
        $manager = $this->managerRegistry->getManager($this->getModuleName());
        if (!$manager instanceof EntityManagerInterface) {
            throw new TypeError('Der Manager entspricht nicht dem EntityManagerInterface-Typ.');
        }

        return $manager;
    }

    abstract protected function getModuleName(): string;
}
