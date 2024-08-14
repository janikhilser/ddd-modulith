<?php

declare(strict_types=1);

namespace App\Loan\Domain\Book\ValueObject;

use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Common\Domain\ValueObject\Uuid;

class BookId extends Uuid
{
    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public static function generate(IUuidGenerator $uuidGenerator): self
    {
        return new self($uuidGenerator->generate());
    }
}
