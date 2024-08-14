<?php

declare(strict_types=1);

namespace DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestModule2Fixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    }
}
