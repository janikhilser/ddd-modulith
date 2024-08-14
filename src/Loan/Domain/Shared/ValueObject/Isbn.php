<?php

declare(strict_types=1);

namespace App\Loan\Domain\Shared\ValueObject;

use App\Common\Domain\Assertion\Assertion;
use App\Common\Domain\Assertion\AssertionFailedException;

readonly class Isbn
{
    private string $isbn;

    private function __construct(string $isbn)
    {
        $this->isbn = $isbn;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $isbn): self
    {
        Assertion::string($isbn, 'Isbn not valid.');

        return new self($isbn);
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }
}
