<?php

declare(strict_types=1);

namespace App\Tests\Unit\Search\Domain\Book;

use App\Common\Domain\Assertion\AssertionFailedException;
use App\Search\Domain\Book\ValueObject\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    public function testInvalidTitleThrowsException(): void
    {
        // Arrange
        $invalidTitle = ' ';

        // Act & Assert
        $this->expectException(AssertionFailedException::class);
        Title::fromString($invalidTitle);
    }
}
