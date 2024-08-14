<?php

declare(strict_types=1);

namespace App\Tests\Integration\Common\Bus;

use App\Common\Application\Command\ICommandBus;
use App\Tests\TestBase\IntegrationTestBase;
use App\Tests\TestData\TestModule1\Application\Command\RaiseDomainEvent\RaiseDomainEventCommand;
use App\Tests\TestData\TestModule1\Application\Command\RaiseDomainEventWithMultipleHandler\RaiseDomainEventWithMultipleHandlerCommand;
use App\Tests\TestData\TestModule1\Application\Command\RaiseDomainEventWithNoHandler\RaiseDomainEventWithNoHandlerCommand;
use App\Tests\TestData\TestModule1\Application\MyCustomException;
use App\Tests\TestData\TestModule1\Infrastructure\Configuration\Module;

class DomainEventBusTest extends IntegrationTestBase
{
    public function testExceptionWillPassed(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);

        $command = new RaiseDomainEventCommand();

        // Act & Assert
        $this->expectException(MyCustomException::class);
        $commandBus->handle($command);
    }

    public function testWillRaisedWhileSaving(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);

        $command = new RaiseDomainEventCommand(false);

        // Act
        $commandBus->handle($command);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    public function testNoHandlersAreAllowed(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);

        $command = new RaiseDomainEventWithNoHandlerCommand();

        // Act
        $commandBus->handle($command);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    public function testMultipleHandlersWorks(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);

        $command = new RaiseDomainEventWithMultipleHandlerCommand();
        ob_start();

        // Act
        $commandBus->handle($command);

        // Assert
        $output = ob_get_clean();
        $this->assertStringContainsString('DummyCreatedMultipleHandlerOne', $output);
        $this->assertStringContainsString('DummyCreatedMultipleHandlerTwo', $output);
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
