<?php

declare(strict_types=1);

namespace App\Tests\Integration\Loan;

use App\Common\Application\Command\ICommandBus;
use App\Common\Application\Query\IQueryBus;
use App\Loan\Application\Command\Book\Buy\BuyBookCommand;
use App\Loan\Application\Command\Publication\Publish\PublishPublicationCommand;
use App\Loan\Application\Query\Book\GetBookById\BookDto;
use App\Loan\Application\Query\Book\GetBookById\BookNotFoundException;
use App\Loan\Application\Query\Book\GetBookById\GetBookByIdQuery;
use App\Loan\Infrastructure\Configuration\Module;
use App\Tests\TestBase\IntegrationTestBase;
use PHPUnit\Framework\MockObject\Exception;

class GetBookDetailTest extends IntegrationTestBase
{
    public function testBookNotFound(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var IQueryBus $queryBus */
        $queryBus = $container->get(IQueryBus::class);

        $query = new GetBookByIdQuery('123');

        // Act & Assert
        $this->expectException(BookNotFoundException::class);
        $queryBus->ask($query);
    }

    /**
     * @throws Exception
     */
    public function testBookFound(): void
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();
        /** @var ICommandBus $commandBus */
        $commandBus = $container->get(ICommandBus::class);
        /** @var IQueryBus $queryBus */
        $queryBus = $container->get(IQueryBus::class);

        $isbn = '123-123-1230';
        $command = new PublishPublicationCommand($isbn);
        $commandBus->handle($command);

        $command = new BuyBookCommand($isbn);
        $id = $commandBus->handle($command);

        $query = new GetBookByIdQuery($id);

        // Act
        /** @var BookDto $result */
        $result = $queryBus->ask($query);

        // Assert
        $this->assertEquals($isbn, $result->isbn);
        $this->assertEquals($id, $result->id);
    }

    protected function getModuleNameForEntityManger(): string
    {
        return Module::NAME;
    }
}
