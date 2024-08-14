<?php

declare(strict_types=1);

namespace App\Loan\Application\Command\Publication\Publish;

use App\Common\Application\Command\ICommand;
use App\Common\Domain\Assertion\AssertionFailedException;
use App\Loan\Domain\Shared\ValueObject\Isbn;

readonly class PublishPublicationCommand implements ICommand
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
