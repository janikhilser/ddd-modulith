<?php

declare(strict_types=1);

namespace App\Loan\Infrastructure\Persistence\Repository;

use App\Common\Infrastructure\Persistence\AggregateNotFoundException;
use App\Common\Infrastructure\Persistence\DoctrineAggregateRepository;
use App\Loan\Domain\Publication\Publication;
use App\Loan\Domain\Publication\Repository\IPublicationRepository;
use App\Loan\Domain\Publication\ValueObject\PublicationId;
use App\Loan\Infrastructure\Configuration\Module;

class PublicationRepository extends DoctrineAggregateRepository implements IPublicationRepository
{
    public function store(Publication $publication): void
    {
        $this->persist($publication);
    }

    /**
     * @throws AggregateNotFoundException
     */
    public function load(PublicationId $publicationId): Publication
    {
        return $this->get(Publication::class, $publicationId->getId());
    }

    protected function getModuleName(): string
    {
        return Module::NAME;
    }
}
