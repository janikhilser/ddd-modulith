<?php

declare(strict_types=1);

namespace App\Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

abstract class AbstractModule
{
    final public function test_domain_darf_von_nichts_abhaengen(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace(sprintf('App\%s\Domain', $this->getModuleName()))
            )
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace(sprintf('App\%s\Domain', $this->getModuleName())),
                Selector::inNamespace('App\Common\Domain'),
                Selector::inNamespace('Doctrine\Common\Collections'),
                Selector::inNamespace('\\'),
            )
            ->because('Die Domain-Schicht sollte auf nichts außerhalb zugreifen.');
    }

    final public function test_application_darf_nur_von_domain_abhaengen(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace(sprintf('App\%s\Application', $this->getModuleName()))
            )
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace(sprintf('App\%s\Domain', $this->getModuleName())),
                Selector::inNamespace(sprintf('App\%s\Application', $this->getModuleName())),
                Selector::inNamespace('/^App\\\\\\w*\\\\Integration/', true),
                Selector::inNamespace('App\Common\Domain'),
                Selector::inNamespace('App\Common\Application'),
                Selector::inNamespace('Assert'),
                Selector::inNamespace('\\'),
            )
            ->because('Die Application-Schicht sollte auf nichts außerhalb zugreifen.');
    }

    abstract protected function getModuleName(): string;
}
