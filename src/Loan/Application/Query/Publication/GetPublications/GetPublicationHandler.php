<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Publication\GetPublications;

use App\Common\Application\Query\IQueryHandler;

readonly class GetPublicationHandler implements IQueryHandler
{
    public function __construct(private IGetPublication $repository)
    {
    }

    /**
     * @return array<PublicationDto>
     */
    public function __invoke(GetPublicationQuery $query): array
    {
        return $this->repository->getPublication();
    }
}
