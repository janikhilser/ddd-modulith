<?php

declare(strict_types=1);

namespace App\Common\Domain\Assertion;

use Assert\Assertion as BaseAssertion;

abstract class Assertion extends BaseAssertion
{
    protected static $exceptionClass = 'App\Common\Domain\Assertion\AssertionFailedException';
}
