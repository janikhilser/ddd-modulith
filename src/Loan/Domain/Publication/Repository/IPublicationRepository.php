<?php

declare(strict_types=1);

namespace App\Loan\Domain\Publication\Repository;

use App\Loan\Domain\Publication\Publication;
use App\Loan\Domain\Publication\ValueObject\PublicationId;

interface IPublicationRepository
{
    public function store(Publication $publication): void;

    public function load(PublicationId $publicationId): Publication;
}
