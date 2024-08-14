<?php

declare(strict_types=1);

namespace App\Loan\Application\Command\Book\Buy;

use App\Common\Application\Command\ICommandHandler;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Loan\Domain\Book\Book;
use App\Loan\Domain\Book\Repository\IBookRepository;
use App\Loan\Domain\Publication\ValueObject\PublicationId;

final readonly class BuyBookHandler implements ICommandHandler
{
    public function __construct(
        private IBookRepository $bookRepository,
        private IGetIdByIsbn $publicationRepository,
        private IUuidGenerator $uuidGenerator
    ) {
    }

    public function __invoke(BuyBookCommand $command): string
    {
        $publicationId = $this->publicationRepository->getIdByIsbn($command->isbn->getIsbn());

        $buch = Book::buy(PublicationId::fromString($publicationId), $this->uuidGenerator);

        $this->bookRepository->store($buch);

        return $buch->getId();
    }
}
