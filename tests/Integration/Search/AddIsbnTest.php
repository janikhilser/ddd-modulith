<?php

declare(strict_types=1);

namespace App\Tests\Integration\Search;

use App\Common\Application\Command\ICommandBus;
use App\Search\Application\Command\Book\AddIsbn\AddIsbnCommand;
use App\Search\Application\Command\Book\Create\CreateBookCommand;
use App\Search\Domain\Book\Book;
use App\Search\Infrastructure\Configuration\Module;
use App\Tests\TestBase\IntegrationTestBase;
use Exception;

class AddIsbnTest extends IntegrationTestBase
{
    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testAddIsbn(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        $commandBus = $container->get(ICommandBus::class);

        $id = $commandBus->handle(new CreateBookCommand(['5555555555'], 'test'));
        $isbn = '123-123-1235';
        $command = new AddIsbnCommand($id, $isbn);

        // Act
        $commandBus->handle($command);

        // Assert
        /** @var Book $book */
        $book = $this->entityManager
            ->getRepository(Book::class)
            ->findOneBy(['id' => $id]);

        $this->assertEquals(2, $book->getIsbns()->count());
        $this->assertEquals(preg_replace('/[^0-9]+/', '', $isbn), $book->getIsbns()[1]->getIsbn());
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
