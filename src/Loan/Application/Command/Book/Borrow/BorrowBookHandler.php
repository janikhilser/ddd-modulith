<?php

declare(strict_types=1);

namespace App\Loan\Application\Command\Book\Borrow;

use App\Common\Application\Command\ICommandHandler;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Loan\Domain\Book\Exception\AlreadyBorrowedException;
use App\Loan\Domain\Book\Repository\IBookRepository;

final readonly class BorrowBookHandler implements ICommandHandler
{
    public function __construct(
        private IBookRepository $bookRepository,
        private IUuidGenerator $uuidGenerator
    ) {
    }

    /**
     * @throws AlreadyBorrowedException
     */
    public function __invoke(BorrowBookCommand $command): void
    {
        $buch = $this->bookRepository->load($command->id);

        $buch->borrow($this->uuidGenerator);

        $this->bookRepository->store($buch);
    }
}
