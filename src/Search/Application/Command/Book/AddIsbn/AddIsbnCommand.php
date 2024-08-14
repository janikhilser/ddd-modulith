<?php

declare(strict_types=1);

namespace App\Search\Application\Command\Book\AddIsbn;

use App\Common\Application\Command\ICommand;
use App\Common\Domain\Assertion\AssertionFailedException;
use App\Search\Domain\Book\ValueObject\BookId;
use App\Search\Domain\Book\ValueObject\Isbn;

readonly class AddIsbnCommand implements ICommand
{
    public BookId $bookId;

    public Isbn $isbn;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $id, string $isbn)
    {
        $this->bookId = BookId::fromString($id);
        $this->isbn = Isbn::fromString($isbn);
    }
}
