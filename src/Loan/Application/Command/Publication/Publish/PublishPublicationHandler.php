<?php

declare(strict_types=1);

namespace App\Loan\Application\Command\Publication\Publish;

use App\Common\Application\Command\ICommandHandler;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Loan\Domain\Publication\Publication;
use App\Loan\Domain\Publication\Repository\IPublicationRepository;

final readonly class PublishPublicationHandler implements ICommandHandler
{
    public function __construct(
        private IPublicationRepository $publicationRepository,
        private IUuidGenerator $uuidGenerator
    ) {
    }

    public function __invoke(PublishPublicationCommand $command): string
    {
        $publication = Publication::publish($command->isbn, $this->uuidGenerator);

        $this->publicationRepository->store($publication);

        return $publication->getId();
    }
}
