<?php

declare(strict_types=1);

namespace App\Tests\Architecture;

class Loan extends AbstractModule
{
    protected function getModuleName(): string
    {
        return 'Loan';
    }
}
