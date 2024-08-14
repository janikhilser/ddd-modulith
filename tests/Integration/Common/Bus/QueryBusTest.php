<?php

declare(strict_types=1);

namespace App\Tests\Integration\Common\Bus;

use App\Common\Application\Query\IQueryBus;
use App\Common\Infrastructure\Bus\NoHandlerException;
use App\Tests\TestBase\IntegrationTestBase;
use App\Tests\TestData\TestModule1\Application\MyCustomException;
use App\Tests\TestData\TestModule1\Application\Query\Default\DefaultQuery;
use App\Tests\TestData\TestModule1\Application\Query\HasNoHandler\HasNoHandlerQuery;
use App\Tests\TestData\TestModule1\Application\Query\ThrowException\ThrowExceptionQuery;
use App\Tests\TestData\TestModule1\Infrastructure\Configuration\Module;

class QueryBusTest extends IntegrationTestBase
{
    public function testExecutedAndReturnsResults(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var IQueryBus $queryBus */
        $queryBus = $container->get(IQueryBus::class);

        $query = new DefaultQuery();

        // Act
        $result = $queryBus->ask($query);

        // Assert
        $this->assertCount(1, $result);
        $this->assertEquals('result', $result[0]);
    }

    public function testExceptionIfNoHandler(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var IQueryBus $queryBus */
        $queryBus = $container->get(IQueryBus::class);

        $query = new HasNoHandlerQuery();
        // Act & Assert
        $this->expectException(NoHandlerException::class);
        $queryBus->ask($query);
    }

    public function testExceptionWillPassed(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var IQueryBus $queryBus */
        $queryBus = $container->get(IQueryBus::class);

        $query = new ThrowExceptionQuery();

        // Act & Assert
        $this->expectException(MyCustomException::class);
        $queryBus->ask($query);
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
