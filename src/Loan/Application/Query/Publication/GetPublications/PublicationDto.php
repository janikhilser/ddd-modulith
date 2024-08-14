<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Publication\GetPublications;

readonly class PublicationDto
{
    public function __construct(
        public string $id,
        public string $isbn
    ) {
    }
}
