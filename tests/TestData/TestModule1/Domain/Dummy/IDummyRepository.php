<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Domain\Dummy;

interface IDummyRepository
{
    public function store(Dummy $dummy): void;

    public function load(DummyId $dummyId): Dummy;
}
