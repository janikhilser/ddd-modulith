<?php

declare(strict_types=1);

namespace App\Search\Domain\Book;

use App\Common\Domain\Aggregate\Aggregate;
use App\Common\Domain\ValueObject\IUuidGenerator;
use App\Search\Domain\Book\Event\BookCreated;
use App\Search\Domain\Book\Event\IsbnAdded;
use App\Search\Domain\Book\Exception\IsbnAlreadyExistsException;
use App\Search\Domain\Book\Specification\IUniqueIsbnSpecification;
use App\Search\Domain\Book\ValueObject\BookId;
use App\Search\Domain\Book\ValueObject\Isbn;
use App\Search\Domain\Book\ValueObject\Title;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;

class Book extends Aggregate
{
    private BookId $id;
    /**
     * @var Collection<int, Isbn>
     */
    private Collection $isbns;
    private Title $title;

    private function __construct(BookId $id)
    {
        $this->id = $id;
    }

    /**
     * @param array<Isbn> $isbns
     *
     * @throws IsbnAlreadyExistsException
     */
    public static function create(
        array $isbns,
        Title $title,
        IUniqueIsbnSpecification $uniqueIsbnSpecification,
        IUuidGenerator $uuidGenerator
    ): self {
        foreach ($isbns as $isbn) {
            $uniqueIsbnSpecification->isUnique($isbn);
        }

        $self = new self(BookId::generate($uuidGenerator));
        $self->isbns = new ArrayCollection($isbns);
        $self->title = $title;

        $self->raise(new BookCreated($isbns));

        return $self;
    }

    /**
     * @throws IsbnAlreadyExistsException
     */
    public function addIsbn(Isbn $isbn, IUniqueIsbnSpecification $uniqueIsbnSpecification): void
    {
        $uniqueIsbnSpecification->isUnique($isbn);

        $this->isbns->add($isbn);

        $this->raise(new IsbnAdded($isbn));
    }

    public function getId(): string
    {
        return $this->id->getId();
    }

    public function getTitle(): string
    {
        return $this->title->toString();
    }

    /**
     * @return ReadableCollection<int, Isbn>
     */
    public function getIsbns(): ReadableCollection
    {
        return $this->isbns;
    }
}
