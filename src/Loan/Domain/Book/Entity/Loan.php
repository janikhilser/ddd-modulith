<?php

declare(strict_types=1);

namespace App\Loan\Domain\Book\Entity;

use App\Common\Domain\Entity\IEntity;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Loan\Domain\Book\ValueObject\LoanId;

class Loan implements IEntity
{
    private LoanId $id;
    private int $sequence;
    private bool $returned;

    public function __construct(int $sequence, IUuidGenerator $uuidGenerator)
    {
        $this->id = LoanId::generate($uuidGenerator);
        $this->sequence = $sequence;
        $this->returned = false;
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function returned(): bool
    {
        return $this->returned;
    }

    public function return(): void
    {
        $this->returned = true;
    }
}
