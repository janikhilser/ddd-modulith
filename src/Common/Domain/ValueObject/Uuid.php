<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use App\Common\Domain\Assertion\Assertion;

abstract class Uuid extends ValueObject
{
    protected readonly string $id;

    public function __construct(string $id)
    {
        Assertion::uuid($id);

        $this->id = $id;
    }

    abstract public static function generate(IUuidGenerator $uuidGenerator): self;

    public function getId(): string
    {
        return $this->id;
    }

    public function equals(Uuid $other): bool
    {
        return $this->id === $other->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
