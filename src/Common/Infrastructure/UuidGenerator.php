<?php

declare(strict_types=1);

namespace App\Common\Infrastructure;

use App\Common\Domain\ValueObject\IUuidGenerator;
use Ramsey\Uuid\Uuid;

class UuidGenerator implements IUuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
