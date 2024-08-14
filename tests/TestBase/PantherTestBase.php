<?php

declare(strict_types=1);

namespace App\Tests\TestBase;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Panther\PantherTestCase;
use TypeError;

abstract class PantherTestBase extends PantherTestCase
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

        $kernel = self::bootKernel();

        $manager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager($this->getModuleNameForEntityManger());

        if (!$manager instanceof EntityManagerInterface) {
            throw new TypeError();
        }

        $this->entityManager = $manager;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreExceptionHandler();
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
