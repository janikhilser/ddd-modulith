<?php

declare(strict_types=1);

namespace App\Tests\Unit\Search\Domain\Book;

use App\Common\Domain\Assertion\AssertionFailedException;
use App\Search\Domain\Book\ValueObject\Isbn;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IsbnTest extends TestCase
{
    public function testInvalidIsbnThrowsException(): void
    {
        // Arrange
        $invalidIsbn = '123456789'; // Ungültige ISBN

        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        Isbn::fromString($invalidIsbn);
    }

    public function testEmptyIsbnThrowsException(): void
    {
        // Arrange
        $invalidIsbn = ' '; // Ungültige ISBN

        // Act & Assert
        $this->expectException(AssertionFailedException::class);
        Isbn::fromString($invalidIsbn);
    }
}
