<?php

declare(strict_types=1);

namespace App\Tests\Integration\Loan;

use App\Common\Application\Command\ICommandBus;
use App\Loan\Application\Command\Publication\Publish\PublishPublicationCommand;
use App\Loan\Domain\Publication\Publication;
use App\Loan\Infrastructure\Configuration\Module;
use App\Tests\TestBase\IntegrationTestBase;

class PublishPublicationTest extends IntegrationTestBase
{
    public function testSuccessful(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);

        $isbn = '923-123-1230';
        $command = new PublishPublicationCommand($isbn);

        // Act
        $id = $commandBus->handle($command);

        // Assert
        /** @var Publication $publication */
        $publication = $this->entityManager
            ->getRepository(Publication::class)
            ->findOneBy(['isbn.isbn' => $isbn]);

        $this->assertEquals($id, $publication->getId());
        $this->assertEquals($isbn, $publication->getIsbn()->getIsbn());
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
