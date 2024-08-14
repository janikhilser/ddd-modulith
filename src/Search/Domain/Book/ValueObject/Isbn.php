<?php

declare(strict_types=1);

namespace App\Search\Domain\Book\ValueObject;

use App\Common\Domain\Assertion\Assertion;
use App\Common\Domain\Assertion\AssertionFailedException;
use App\Common\Domain\ValueObject\ValueObject;
use InvalidArgumentException;

class Isbn extends ValueObject
{
    private readonly string $isbn;

    private function __construct(string $isbn)
    {
        $cleanIsbn = str_replace([' ', '-'], '', $isbn);

        if (!ctype_digit($cleanIsbn)) {
            throw new InvalidArgumentException('The isbn should only contain digits');
        }

        $length = strlen($cleanIsbn);
        if (10 !== $length && 13 !== $length) {
            throw new InvalidArgumentException('The isbn should be 10 or 13 digits');
        }

        $this->isbn = $cleanIsbn;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $isbn): self
    {
        Assertion::notBlank($isbn, 'Not a valid isbn');

        return new self($isbn);
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }
}
