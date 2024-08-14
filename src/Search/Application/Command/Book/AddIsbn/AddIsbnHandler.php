<?php

declare(strict_types=1);

namespace App\Search\Application\Command\Book\AddIsbn;

use App\Common\Application\Command\ICommandHandler;
use App\Search\Domain\Book\Exception\IsbnAlreadyExistsException;
use App\Search\Domain\Book\Repository\IBookRepository;
use App\Search\Domain\Book\Specification\IUniqueIsbnSpecification;

final readonly class AddIsbnHandler implements ICommandHandler
{
    public function __construct(
        private IBookRepository $bookRepository,
        private IUniqueIsbnSpecification $uniqueIsbnSpecification
    ) {
    }

    /**
     * @throws IsbnAlreadyExistsException
     */
    public function __invoke(AddIsbnCommand $command): void
    {
        $book = $this->bookRepository->load($command->bookId);

        $book->addIsbn($command->isbn, $this->uniqueIsbnSpecification);

        $this->bookRepository->store($book);
    }
}
