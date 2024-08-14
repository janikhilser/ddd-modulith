<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Infrastructure\Persistence\Type;

use App\Common\Infrastructure\Persistence\UuidType;
use App\Tests\TestData\TestModule1\Domain\Dummy\DummyId;

class DummyIdType extends UuidType
{
    public const DUMMY_ID = 'test_module_1_dummy_id';

    public function getName(): string
    {
        return static::DUMMY_ID;
    }

    protected function getValueObjectClassName(): string
    {
        return DummyId::class;
    }
}
