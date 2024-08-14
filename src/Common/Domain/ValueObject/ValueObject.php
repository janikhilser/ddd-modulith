<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

abstract class ValueObject
{
    /**
     * Dieses Feld existiert nur, da mit Doctrine ein Array<ValueObject> nicht anders abgebildet werden kann, also eine
     * Entität zu simulieren, wofür eine Id benötigt wird. Sollte Doctrine irgendwann eine andere Möglichkeit bieten,
     * sollte diese jener hier vorgezogen werden.
     *
     * @noinspection PhpUnused
     */
    protected readonly int $backingId; // @phpstan-ignore-line
}
