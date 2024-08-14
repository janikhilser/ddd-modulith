<?php

declare(strict_types=1);

namespace App\Tests\Integration\Search;

use App\Common\Application\Command\ICommandBus;
use App\Search\Application\Command\Book\Create\CreateBookCommand;
use App\Search\Domain\Book\Book;
use App\Search\Infrastructure\Configuration\Module;
use App\Tests\TestBase\IntegrationTestBase;
use Exception;
use PHPUnit\Framework\Attributes\Test;

class CreateBookTest extends IntegrationTestBase
{
    /**
     * @throws Exception
     */
    #[Test]
    public function invoke_validCommand_bookCreated(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();

        $commandBus = $container->get(ICommandBus::class);
        $isbn = '123-123-1234';
        $title = 'sadfsdagfaew';
        $command = new CreateBookCommand([$isbn], $title);

        // Act
        $commandBus->handle($command);

        // Assert
        /** @var Book $book */
        $book = $this->entityManager
            ->getRepository(Book::class)
            ->findOneBy(['title.title' => $title]);

        $this->assertEquals(preg_replace('/[^0-9]+/', '', $isbn), $book->getIsbns()[0]->getIsbn());
        $this->assertEquals($title, $book->getTitle());
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
