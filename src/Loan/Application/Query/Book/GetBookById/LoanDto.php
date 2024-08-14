<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Book\GetBookById;

readonly class LoanDto
{
    public function __construct(
        public int $id,
        public bool $returned
    ) {
    }
}
