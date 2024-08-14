<?php

declare(strict_types=1);

namespace DataFixtures;

use App\Tests\TestData\TestModule1\Domain\Dummy\Dummy;
use App\Tests\TestData\TestModule1\Domain\Dummy\DummyId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

class TestModule1Fixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        if (!$manager instanceof EntityManagerInterface) {
            throw new Exception('The manager must be an instance of EntityManagerInterface');
        }

        $firstDummyId = 'b7631f5b-18af-44da-acf9-c5093d39067f';
        $dummy = new Dummy(DummyId::fromString($firstDummyId));
        $manager->persist($dummy);

        $dummy = new Dummy(DummyId::fromString('27631f53-18af-44da-acf9-c5093d39067f'));
        $dummy->setAccidentalId(null);
        $manager->persist($dummy);

        $manager->flush();

        $entityClass = Dummy::class;
        $dql = "UPDATE $entityClass e SET e.accidentalId = :newValue WHERE e.id = :id";
        $query = $manager->createQuery($dql);
        $query->setParameter('newValue', '[123255}23daaa3');
        $query->setParameter('id', $firstDummyId);
        $query->execute();
    }
}
