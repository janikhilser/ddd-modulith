<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Publication\GetPublications;

interface IGetPublication
{
    /**
     * @return array<PublicationDto>
     */
    public function getPublication(): array;
}
