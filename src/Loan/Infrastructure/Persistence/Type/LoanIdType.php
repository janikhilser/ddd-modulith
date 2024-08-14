<?php

declare(strict_types=1);

namespace App\Loan\Infrastructure\Persistence\Type;

use App\Common\Infrastructure\Persistence\UuidType;
use App\Loan\Domain\Book\ValueObject\LoanId;

class LoanIdType extends UuidType
{
    public const LOAN_ID = 'loan_loan_id';

    public function getName(): string
    {
        return static::LOAN_ID;
    }

    protected function getValueObjectClassName(): string
    {
        return LoanId::class;
    }
}
