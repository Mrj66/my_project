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
    description: 'Test the database connection',
)]
class TestDatabaseConnectionCommand extends Command
{
    protected static $defaultName = 'app:test-database-connection';

    protected function configure(): void
    {
        $this->setDescription('Tests the database connection.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=C:/Users/junio/Downloads/GitHub/my_project/var/bdd/data.mdb;";
            $username = ""; 
            $password = "";

            $pdo = new \PDO($dsn, $username, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            echo "Connected successfully";
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}