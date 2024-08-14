<?php

declare(strict_types=1);

namespace App\Search\Application\Command\Book\Create;

use App\Common\Application\Command\ICommand;
use App\Common\Domain\Assertion\AssertionFailedException;
use App\Search\Domain\Book\ValueObject\Isbn;
use App\Search\Domain\Book\ValueObject\Title;

readonly class CreateBookCommand implements ICommand
{
    /**
     * @var array<Isbn>
     */
    public array $isbns;

    public Title $title;

    /**
     * @param array<string> $isbns
     *
     * @throws AssertionFailedException
     */
    public function __construct(array $isbns, string $titel)
    {
        $typedIsbns = [];
        foreach ($isbns as $isbn) {
            $typedIsbns[] = Isbn::fromString($isbn);
        }
        $this->isbns = $typedIsbns;
        $this->title = Title::fromString($titel);
    }
}
