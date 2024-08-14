<?php

declare(strict_types=1);

namespace App\Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class Common
{
    public function test_es_darf_nicht_auf_module_zugegriffen_werden(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Common'))
            ->shouldNotDependOn()
            ->classes(Selector::inNamespace('App'))
            ->excluding(Selector::inNamespace('App\Common'))
            ->because('Nichts aus dem Common-Namespace darf auf Module zugreifen');
    }

    final public function test_domain_darf_von_nichts_abhaengen(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('App\Common\Domain')
            )
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace('App\Common\Domain'),
                Selector::inNamespace('Assert'),
                Selector::inNamespace('\\'),
            )
            ->because('Domain should not use code from other contexts');
    }

    final public function test_application_darf_nur_von_domain_abhaengen(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::inNamespace('App\Common\Application')
            )
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace('App\Common\Application'),
                Selector::inNamespace('App\Common\Domain'),
                Selector::inNamespace('\\'),
            )
            ->because('Die Application-Schicht sollte auf nichts außerhalb zugreifen.');
    }
}
