<?php

declare(strict_types=1);

namespace App\Tests\Application\Loan;

use App\Tests\TestBase\ApplicationTestBase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\WithoutErrorHandler;

class PublicationTest extends ApplicationTestBase
{
    #[Test]
    #[WithoutErrorHandler]
    public function overview_onePublicationExists_onePublicationShown(): void
    {
        // Arrange
        $client = static::createClient();

        // Act
        $client->request('GET', '/loan/publication/');

        // Assert
        $this->assertResponseIsSuccessful();
        $this->assertSelectorCount(1, '#publication li:contains("1")');
        $this->assertSelectorTextContains('#publication li', '34d30c98-c691-4b10-8f71-647e479f3451');
    }
}
