<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Command;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TypeError;

#[AsCommand(name: 'app:is-database-available')]
class IsDatabaseAvailableCommand extends Command
{
    private ManagerRegistry $managerRegistry;

    public function __construct(
        ManagerRegistry $managerRegistry,
    ) {
        parent::__construct();
        $this->managerRegistry = $managerRegistry;
    }

    private function entityManager(string $entityManagerName): EntityManagerInterface
    {
        $manager = $this->managerRegistry->getManager($entityManagerName);
        if (!$manager instanceof EntityManagerInterface) {
            throw new TypeError('Der Manager entspricht nicht dem EntityManagerInterface-Typ.');
        }

        return $manager;
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entityManagerName = $input->getArgument('entityManagerName');
        try {
            $entityManager = $this->entityManager($entityManagerName);
            $entityManager->getConnection()->getNativeConnection();
        } catch (Exception $e) {
            $code = $e->getCode();
            if (1049 == $code) {
                throw new Exception("Unknown database '$entityManagerName'.");
            } elseif (2002 == $code) {
                throw new Exception('Connection could not be established.');
            }
            throw $e;
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('entityManagerName', InputArgument::REQUIRED, 'The name of the entity manager');
    }
}
