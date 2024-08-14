<?php

declare(strict_types=1);

namespace App\Loan\Application\Command\Book\Buy;

use App\Common\Application\Command\ICommand;
use App\Common\Domain\Assertion\AssertionFailedException;
use App\Loan\Domain\Shared\ValueObject\Isbn;

readonly class BuyBookCommand implements ICommand
{
    public Isbn $isbn;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $isbn)
    {
        $this->isbn = Isbn::fromString($isbn);
    }
}
