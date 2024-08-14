<?php

declare(strict_types=1);

namespace App\Search\Application\Command\Book\Create;

use App\Common\Application\Command\ICommandHandler;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Search\Domain\Book\Book;
use App\Search\Domain\Book\Exception\IsbnAlreadyExistsException;
use App\Search\Domain\Book\Repository\IBookRepository;
use App\Search\Domain\Book\Specification\IUniqueIsbnSpecification;

final readonly class CreateBookHandler implements ICommandHandler
{
    public function __construct(
        private IBookRepository $bookRepository,
        private IUniqueIsbnSpecification $uniqueIsbnSpecification,
        private IUuidGenerator $uuidGenerator
    ) {
    }

    /**
     * @throws IsbnAlreadyExistsException
     */
    public function __invoke(CreateBookCommand $command): string
    {
        $book = Book::create($command->isbns, $command->title, $this->uniqueIsbnSpecification, $this->uuidGenerator);

        $this->bookRepository->store($book);

        return $book->getId();
    }
}
