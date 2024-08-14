<?php

declare(strict_types=1);

namespace App\Common\Domain\Assertion;

use Assert\InvalidArgumentException;

class AssertionFailedException extends InvalidArgumentException implements \Assert\AssertionFailedException
{
}
