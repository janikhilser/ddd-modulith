<?php

declare(strict_types=1);

namespace App\Loan\Application\Command\Book\Return;

use App\Common\Application\Command\ICommandHandler;
use App\Loan\Domain\Book\Repository\IBookRepository;
use App\Loan\Domain\Buch\Exception\LoanNotFoundException;

final readonly class ReturnBookHandler implements ICommandHandler
{
    public function __construct(
        private IBookRepository $bookRepository
    ) {
    }

    /**
     * @throws LoanNotFoundException
     */
    public function __invoke(ReturnBookCommand $command): void
    {
        $buch = $this->bookRepository->load($command->id);

        $buch->return();

        $this->bookRepository->store($buch);
    }
}
