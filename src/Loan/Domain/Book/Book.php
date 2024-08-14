<?php

declare(strict_types=1);

namespace App\Loan\Domain\Book;

use App\Common\Domain\Aggregate\Aggregate;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Loan\Domain\Book\Entity\Loan;
use App\Loan\Domain\Book\Exception\AlreadyBorrowedException;
use App\Loan\Domain\Book\ValueObject\BookId;
use App\Loan\Domain\Buch\Exception\LoanNotFoundException;
use App\Loan\Domain\Publication\ValueObject\PublicationId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Book extends Aggregate
{
    private BookId $id;
    /**
     * @var Collection<int, Loan>
     */
    private Collection $loans;
    private PublicationId $publicationId;

    private function __construct(BookId $id, PublicationId $publicationId)
    {
        $this->id = $id;
        $this->publicationId = $publicationId;
        $this->loans = new ArrayCollection();
    }

    public static function buy(PublicationId $publicationId, IUuidGenerator $uuidGenerator): self
    {
        return new self(BookId::generate($uuidGenerator), $publicationId);
    }

    /**
     * @throws AlreadyBorrowedException
     */
    public function borrow(IUuidGenerator $uuidGenerator): void
    {
        if ($this->areLoansOpen()) {
            throw new AlreadyBorrowedException();
        }

        $loan = new Loan($this->loans->count() + 1, $uuidGenerator);
        $this->loans->add($loan);
    }

    public function areLoansOpen(): bool
    {
        return $this->loans->exists(function (int $i, Loan $loan) {
            return !$loan->returned();
        });
    }

    /**
     * @throws LoanNotFoundException
     */
    public function return(): void
    {
        /** @var Loan $notReturnedLoan */
        $notReturnedLoan = $this->loans->findFirst(function (int $i, Loan $loan) {
            return !$loan->returned();
        });

        if (null == $notReturnedLoan) {
            throw new LoanNotFoundException();
        }

        $notReturnedLoan->return();
    }

    public function getPublicationId(): string
    {
        return $this->publicationId->getId();
    }

    public function getId(): string
    {
        return $this->id->getId();
    }
}
