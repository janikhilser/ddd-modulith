<?php

declare(strict_types=1);

namespace App\Loan\Infrastructure\Persistence\Type;

use App\Common\Infrastructure\Persistence\UuidType;
use App\Loan\Domain\Publication\ValueObject\PublicationId;

class PublicationIdType extends UuidType
{
    public const PUBLICATION_ID = 'loan_publication_id';

    public function getName(): string
    {
        return static::PUBLICATION_ID;
    }

    protected function getValueObjectClassName(): string
    {
        return PublicationId::class;
    }
}
