<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Domain\Dummy;

use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Common\Domain\ValueObject\Uuid;

class DummyUuid extends Uuid
{
    public static function generate(IUuidGenerator $uuidGenerator): Uuid
    {
        return new self($uuidGenerator->generate());
    }
}
