<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Book\GetBookById;

readonly class BookDto
{
    /**
     * @param array<LoanDto> $loans
     */
    public function __construct(
        public string $id,
        public string $isbn,
        public array $loans
    ) {
    }
}
