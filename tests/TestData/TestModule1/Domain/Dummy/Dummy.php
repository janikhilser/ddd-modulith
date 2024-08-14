<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Domain\Dummy;

use App\Common\Domain\Aggregate\Aggregate;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Tests\TestData\TestModule1\Domain\Dummy\DomainEvent\DummyCreated;
use App\Tests\TestData\TestModule1\Domain\Dummy\DomainEvent\DummyCreatedMultipleHandler;
use App\Tests\TestData\TestModule1\Domain\Dummy\DomainEvent\DummyCreatedNoHandler;

class Dummy extends Aggregate
{
    private DummyId $id;

    private mixed $accidentalId;

    public function __construct(DummyId $id)
    {
        $this->id = $id;
    }

    public static function create(IUuidGenerator $uuidGenerator): self
    {
        return new self(DummyId::generate($uuidGenerator));
    }

    public static function createWithEvent(IUuidGenerator $uuidGenerator): self
    {
        $self = new self(DummyId::generate($uuidGenerator));
        $self->raise(new DummyCreated());

        return $self;
    }

    public static function createWithEventMultipleHandler(IUuidGenerator $uuidGenerator): self
    {
        $self = new self(DummyId::generate($uuidGenerator));
        $self->raise(new DummyCreatedMultipleHandler());

        return $self;
    }

    public static function createWithEventNoHandler(IUuidGenerator $uuidGenerator): self
    {
        $self = new self(DummyId::generate($uuidGenerator));
        $self->raise(new DummyCreatedNoHandler());

        return $self;
    }

    public function getId(): string
    {
        return $this->id->getId();
    }

    public function setAccidentalId(mixed $id): void
    {
        $this->accidentalId = $id;
    }

    public function getAccidentalId(): mixed
    {
        return $this->accidentalId;
    }
}
