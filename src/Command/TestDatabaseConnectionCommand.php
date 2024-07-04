<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\DBAL\Connection;

#[AsCommand(
    name: 'TestDatabaseConnection',
    description: 'Add a short description for your command',
)]
class TestDatabaseConnectionCommand extends Command
{
    protected static $defaultName = 'app:test-database-connection';
    private $connection;
    public function __construct(Connection $connection)
    {
        parent::__construct();
        $this->connection = $connection;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Tests the database connection.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->connection->connect();
            $io->success('Connected to the database successfully!');
        } catch (\Doctrine\DBAL\Exception $e) {
            $io->error('Connection failed: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}
