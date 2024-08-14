<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetBooksByTitle;

use App\Common\Application\Query\IQuery;
use App\Common\Domain\Assertion\AssertionFailedException;
use App\Search\Domain\Book\ValueObject\Title;

final readonly class GetBooksByTitleQuery implements IQuery
{
    public Title $title;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $titel)
    {
        $this->title = Title::fromString($titel);
    }
}
