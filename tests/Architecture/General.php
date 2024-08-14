<?php

declare(strict_types=1);

namespace App\Tests\Architecture;

use App\Common\Application\Event\IIntegrationEvent;
use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class General
{
    public function test_integrationEvent_liegt_in_richtigem_namespace(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::all())
            ->excluding(
                Selector::inNamespace('/^App\\\\\\w*\\\\Integration/', true)
            )
            ->shouldNotImplement()
            ->classes(Selector::classname(IIntegrationEvent::class))
            ->because('IntegrationEvents dürfen nur im Ordner IntegrationEvent einer Subdomäne liegen');
    }
}
