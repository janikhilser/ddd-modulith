<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

interface IUuidGenerator
{
    public function generate(): string;
}
