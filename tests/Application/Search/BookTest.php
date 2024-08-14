<?php

declare(strict_types=1);

namespace App\Tests\Application\Search;

use App\Tests\TestBase\ApplicationTestBase;

class BookTest extends ApplicationTestBase
{
    public function testIndex(): void
    {
        // Arrange
        $client = static::createClient();

        // Act
        $client->request('GET', '/search/book/search');

        // Assert
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Book-Search');
    }

    public function testBuchAnlegen(): void
    {
        // Arrange
        $client = static::createClient();

        $crawler = $client->request('GET', '/search/book/search');

        $buttonCrawlerNode = $crawler->selectButton('Create book');

        $form = $buttonCrawlerNode->form();

        $form['isbn'] = '111-111-1111';
        $form['title'] = 'TestBook!';

        // Act
        $client->submit($form);

        // Assert
        $this->assertResponseStatusCodeSame(302);
    }
}
