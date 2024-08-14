<?php

declare(strict_types=1);

namespace App\Tests\Integration\Common\Persistence;

use App\Common\Application\Command\ICommandBus;
use App\Tests\TestBase\IntegrationTestBase;
use App\Tests\TestData\TestModule1\Application\Command\SetAccidentalId\SetAccidentalIdCommand;
use App\Tests\TestData\TestModule1\Domain\Dummy\Dummy;
use App\Tests\TestData\TestModule1\Domain\Dummy\DummyId;
use App\Tests\TestData\TestModule1\Domain\Dummy\IDummyRepository;
use App\Tests\TestData\TestModule1\Infrastructure\Configuration\Module;
use Doctrine\DBAL\Types\ConversionException;
use PHPUnit\Framework\Attributes\Test;

class UuidTypeTest extends IntegrationTestBase
{
    #[Test]
    public function convertToDatabaseValue_invalidValue_exceptionThrown(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);

        $command = new SetAccidentalIdCommand(['Test', 123]);

        // Act & Assert
        $this->expectException(ConversionException::class);
        $commandBus->handle($command);
    }

    #[Test]
    public function convertToDatabaseValue_null_nullStored(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);

        $command = new SetAccidentalIdCommand(null);

        // Act
        $dummyId = $commandBus->handle($command);

        // Assert
        $dummy = $this->entityManager
            ->getRepository(Dummy::class)
            ->findOneBy(['id' => $dummyId]);

        $this->assertNull($dummy->getAccidentalId());
    }

    #[Test]
    public function convertToPHPValue_invalidValue_exceptionThrown(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var IDummyRepository $repository */
        $repository = $container->get(IDummyRepository::class);

        // Act & Assert
        $this->expectException(ConversionException::class);
        $repository->load(DummyId::fromString('b7631f5b-18af-44da-acf9-c5093d39067f'));
    }

    #[Test]
    public function convertToPHPValue_null_nullLoaded(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var IDummyRepository $repository */
        $repository = $container->get(IDummyRepository::class);

        // Act
        $dummy = $repository->load(DummyId::fromString('27631f53-18af-44da-acf9-c5093d39067f'));

        // Assert
        $this->assertNull($dummy->getAccidentalId());
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
