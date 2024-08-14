<?php

declare(strict_types=1);

namespace App\Tests\Application\Loan;

use App\Tests\TestBase\ApplicationTestBase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\WithoutErrorHandler;

class BookTest extends ApplicationTestBase
{
    #[Test]
    #[WithoutErrorHandler]
    public function buyForm_requestSite_siteShown(): void
    {
        // Arrange
        $client = static::createClient();

        // Act
        $client->request('GET', '/loan/book/buy');

        // Assert
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Buy book');
    }

    #[Test]
    #[WithoutErrorHandler]
    public function buy_bookNotExisting_errorIsIntercepted(): void
    {
        // Arrange
        $client = static::createClient();
        $client->request('GET', '/loan/book/buy');

        // Act
        $client->submitForm('Buy book', [
            'count' => '5',
            'isbn' => '1231231231',
        ]);

        // Assert
        $this->assertResponseIsSuccessful();
    }
}
