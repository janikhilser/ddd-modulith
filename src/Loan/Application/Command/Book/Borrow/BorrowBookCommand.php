<?php

declare(strict_types=1);

namespace App\Loan\Application\Command\Book\Borrow;

use App\Common\Application\Command\ICommand;
use App\Loan\Domain\Book\ValueObject\BookId;

readonly class BorrowBookCommand implements ICommand
{
    public BookId $id;

    public function __construct(string $id)
    {
        $this->id = BookId::fromString($id);
    }
}
