<?php

declare(strict_types=1);

namespace App\Tests\Integration\Common\Command;

use App\Tests\TestBase\IntegrationTestBase;
use App\Tests\TestData\TestModule1\Infrastructure\Configuration\Module;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class IsDatabaseAvailableCommandTest extends IntegrationTestBase
{
    #[Test]
    public function execute_availableDatabase_returnSuccess(): void
    {
        // Arrange
        self::bootKernel();
        $application = new Application(self::$kernel);
        $command = $application->find('app:is-database-available');
        $commandTester = new CommandTester($command);

        // Act
        $commandTester->execute([
            'entityManagerName' => 'common',
        ]);

        // Assert
        $commandTester->assertCommandIsSuccessful();
    }

    #[Test]
    public function execute_noDatabaseServer_connectionCouldNotBeEstablished(): void
    {
        // Arrange
        self::bootKernel();
        $application = new Application(self::$kernel);
        $command = $application->find('app:is-database-available');
        $commandTester = new CommandTester($command);

        // Act & Assert
        $this->expectExceptionMessage('Connection could not be established.');
        $commandTester->execute([
            'entityManagerName' => 'test_server_not_existing',
        ]);
    }

    #[Test]
    public function execute_noDatabase_connectionCouldNotBeEstablished(): void
    {
        // Arrange
        self::bootKernel();
        $application = new Application(self::$kernel);
        $command = $application->find('app:is-database-available');
        $commandTester = new CommandTester($command);

        // Act & Assert
        $this->expectExceptionMessage("Unknown database 'test_database_not_existing'.");
        $commandTester->execute([
            'entityManagerName' => 'test_database_not_existing',
        ]);
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
