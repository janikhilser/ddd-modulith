<?php

declare(strict_types=1);

namespace App\Tests\TestBase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationTestBase extends WebTestCase
{
    public function setUp(): void
    {
        if (!TestHelper::isTestDbAvailable()) {
            $this->markTestSkipped(
                'The database is not available.'
            );
        }
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
