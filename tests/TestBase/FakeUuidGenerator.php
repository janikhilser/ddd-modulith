<?php

declare(strict_types=1);

namespace App\Tests\TestBase;

use App\Common\Domain\ValueObject\IUuidGenerator;

readonly class FakeUuidGenerator implements IUuidGenerator
{
    public function __construct(private string $uuid)
    {
    }

    public function generate(): string
    {
        return $this->uuid;
    }
}
