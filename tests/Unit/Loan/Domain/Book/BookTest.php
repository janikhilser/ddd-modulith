<?php

declare(strict_types=1);

namespace App\Tests\Unit\Loan\Domain\Book;

use App\Common\Infrastructure\UuidGenerator;
use App\Loan\Domain\Book\Book;
use App\Loan\Domain\Book\Exception\AlreadyBorrowedException;
use App\Loan\Domain\Publication\ValueObject\PublicationId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    #[Test]
    public function buy_validInput_returnBook(): void
    {
        // Arrange
        $publicationId = '2ee59717-2439-414f-b32a-0cc906e502bc';

        // Act
        $book = Book::buy(PublicationId::fromString($publicationId), new UuidGenerator());

        // Assert
        $this->assertNotNull($book->getId());
        $this->assertSame($book->getPublicationId(), $publicationId);
    }

    public function testLoanIsNotOpen(): void
    {
        // Arrange
        $book = Book::buy(PublicationId::fromString('2ee59717-2439-414f-b32a-0cc906e502bc'), new UuidGenerator());

        // Act
        $loansOpen = $book->areLoansOpen();

        // Assert
        $this->assertFalse($loansOpen);
    }

    /**
     * @throws AlreadyBorrowedException
     */
    public function testLoanIsOpen(): void
    {
        // Arrange
        $book = Book::buy(PublicationId::fromString('2ee59717-2439-414f-b32a-0cc906e502bc'), new UuidGenerator());
        $book->borrow(new UuidGenerator());

        // Act
        $loansOpen = $book->areLoansOpen();

        // Assert
        $this->assertTrue($loansOpen);
    }
}
