<?php

declare(strict_types=1);

namespace App\Tests\Integration\Loan;

use App\Common\Application\Command\ICommandBus;
use App\Loan\Application\Command\Book\Buy\BuyBookCommand;
use App\Loan\Application\Command\Publication\Publish\PublishPublicationCommand;
use App\Loan\Domain\Book\Book;
use App\Loan\Infrastructure\Configuration\Module;
use App\Tests\TestBase\IntegrationTestBase;

class BuyBookTest extends IntegrationTestBase
{
    public function testSuccessful(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);

        $isbn = '193-123-1230';
        $command = new PublishPublicationCommand($isbn);
        $publicationId = $commandBus->handle($command);

        $command = new BuyBookCommand($isbn);

        // Act
        $id = $commandBus->handle($command);

        // Assert
        /** @var Book $buch */
        $buch = $this->entityManager
            ->getRepository(Book::class)
            ->findOneBy(['publicationId' => $publicationId]);

        $this->assertEquals($id, $buch->getId());
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
