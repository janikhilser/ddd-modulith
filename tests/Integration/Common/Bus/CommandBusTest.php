<?php

declare(strict_types=1);

namespace App\Tests\Integration\Common\Bus;

use App\Common\Application\Command\ICommandBus;
use App\Common\Infrastructure\Bus\NoHandlerException;
use App\Tests\TestBase\IntegrationTestBase;
use App\Tests\TestData\TestModule1\Application\Command\DoNothing\DoNothingCommand;
use App\Tests\TestData\TestModule1\Application\Command\HasNoHandler\HasNoHandlerCommand;
use App\Tests\TestData\TestModule1\Application\Command\ThrowException\ThrowExceptionCommand;
use App\Tests\TestData\TestModule1\Application\MyCustomException;
use App\Tests\TestData\TestModule1\Infrastructure\Configuration\Module;

class CommandBusTest extends IntegrationTestBase
{
    public function testExecutedAndReturnsResults(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);

        $command = new DoNothingCommand();

        // Act
        $result = $commandBus->handle($command);

        // Assert
        $this->assertEquals('test-id', $result);
    }

    public function testExceptionIfNoHandler(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        $commandBus = $container->get(ICommandBus::class);

        $command = new HasNoHandlerCommand();

        // Act & Assert
        $this->expectException(NoHandlerException::class);
        $commandBus->handle($command);
    }

    public function testExceptionWillPassed(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        $commandBus = $container->get(ICommandBus::class);

        $command = new ThrowExceptionCommand();

        // Act & Assert
        $this->expectException(MyCustomException::class);
        $commandBus->handle($command);
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
