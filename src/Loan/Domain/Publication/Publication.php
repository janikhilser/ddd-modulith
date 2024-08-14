<?php

declare(strict_types=1);

namespace App\Loan\Domain\Publication;

use App\Common\Domain\Aggregate\Aggregate;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Loan\Domain\Publication\ValueObject\PublicationId;
use App\Loan\Domain\Shared\ValueObject\Isbn;

class Publication extends Aggregate
{
    private PublicationId $id;
    private Isbn $isbn;

    private function __construct(PublicationId $id, Isbn $isbn)
    {
        $this->id = $id;
        $this->isbn = $isbn;
    }

    public static function publish(Isbn $isbn, IUuidGenerator $uuidGenerator): self
    {
        return new self(PublicationId::generate($uuidGenerator), $isbn);
    }

    public function getId(): string
    {
        return $this->id->getId();
    }

    public function getIsbn(): Isbn
    {
        return $this->isbn;
    }
}
