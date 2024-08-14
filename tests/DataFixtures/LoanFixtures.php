<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Loan\Domain\Publication\Publication;
use App\Loan\Domain\Shared\ValueObject\Isbn;
use App\Tests\TestBase\FakeUuidGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoanFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $publication = Publication::publish(
            Isbn::fromString('1234567890'),
            new FakeUuidGenerator('34d30c98-c691-4b10-8f71-647e479f3451')
        );
        $manager->persist($publication);

        $manager->flush();
    }
}
