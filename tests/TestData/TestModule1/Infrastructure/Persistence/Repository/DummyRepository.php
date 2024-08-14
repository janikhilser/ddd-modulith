<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Infrastructure\Persistence\Repository;

use App\Common\Infrastructure\Persistence\AggregateNotFoundException;
use App\Common\Infrastructure\Persistence\DoctrineAggregateRepository;
use App\Tests\TestData\TestModule1\Domain\Dummy\Dummy;
use App\Tests\TestData\TestModule1\Domain\Dummy\DummyId;
use App\Tests\TestData\TestModule1\Domain\Dummy\IDummyRepository;
use App\Tests\TestData\TestModule1\Infrastructure\Configuration\Module;

class DummyRepository extends DoctrineAggregateRepository implements IDummyRepository
{
    public function store(Dummy $dummy): void
    {
        $this->persist($dummy);
    }

    /**
     * @throws AggregateNotFoundException
     */
    public function load(DummyId $dummyId): Dummy
    {
        return $this->get(Dummy::class, $dummyId->getId());
    }

    protected function getModuleName(): string
    {
        return Module::NAME;
    }
}
