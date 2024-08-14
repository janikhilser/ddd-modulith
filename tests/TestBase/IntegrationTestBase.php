<?php

declare(strict_types=1);

namespace App\Tests\TestBase;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use TypeError;

abstract class IntegrationTestBase extends KernelTestCase
{
    abstract protected function getModuleNameForEntityManger(): string;

    protected EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        if (!TestHelper::isTestDbAvailable()) {
            $this->markTestSkipped(
                'The database is not available.'
            );
        }

        $kernel = KernelTestCase::bootKernel();

        $manager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager($this->getModuleNameForEntityManger());

        if (!$manager instanceof EntityManagerInterface) {
            throw new TypeError();
        }

        $this->entityManager = $manager;
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->restoreExceptionHandler();

        $this->entityManager->close();
    }

    protected function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn () => null);

            restore_exception_handler();

            if (null === $previousHandler) {
                break;
            }

            restore_exception_handler();
        }
    }
}
