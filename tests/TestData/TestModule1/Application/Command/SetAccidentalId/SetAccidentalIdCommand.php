<?php

declare(strict_types=1);

namespace App\Tests\TestData\TestModule1\Application\Command\SetAccidentalId;

use App\Common\Application\Command\ICommand;

class SetAccidentalIdCommand implements ICommand
{
    public function __construct(public mixed $id)
    {
    }
}
