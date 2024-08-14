<?php

declare(strict_types=1);

namespace App\Tests\Unit\Search\Domain\Book;

use App\Common\Infrastructure\UuidGenerator;
use App\Search\Domain\Book\Book;
use App\Search\Domain\Book\ValueObject\Isbn;
use App\Search\Domain\Book\ValueObject\Title;
use PHPUnit\Framework\TestCase;

class BuchTest extends TestCase
{
    public function testValidBookWillBeCreated(): void
    {
        // Arrange
        $title = 'TestTitle';
        $isbn = '123-123-1233';

        // Act
        $book = Book::create([Isbn::fromString($isbn)], Title::fromString($title), new SpecificationMock(), new UuidGenerator());

        // Assert
        $this->assertNotNull($book->getId());
        $this->assertEquals($book->getTitle(), $title);
        $this->assertEquals(preg_replace('/[^0-9]+/', '', $isbn), $book->getIsbns()->first()->getIsbn());
    }
}
