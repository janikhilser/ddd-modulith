<?php

declare(strict_types=1);

namespace App\Search\Domain\Book\ValueObject;

use App\Common\Domain\Assertion\Assertion;
use App\Common\Domain\Assertion\AssertionFailedException;
use App\Common\Domain\ValueObject\ValueObject;
use Stringable;

final class Title extends ValueObject implements Stringable
{
    private function __construct(private readonly string $title)
    {
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $title): self
    {
        Assertion::notBlank($title, 'Not a valid title');

        return new self($title);
    }

    public function toString(): string
    {
        return $this->title;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
