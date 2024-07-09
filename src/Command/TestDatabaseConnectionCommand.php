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

    private $connection;

    public function __construct(Connection $connection)
    {
        parent::__construct();
        $this->connection = $connection;
    }

    protected function configure(): void
    {
        $this->setDescription('Tests the database connection.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->connection->executeQuery('SELECT 1');
            $io->success('Doctrine connection successful!');

            $dsn = "Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=C:\Users\junio\Downloads\FACAPPLIV3\FACAPPLIV3\data.mdb" . $_ENV['DB_PATH'];
            $odbcConnection = odbc_connect($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);

            if ($odbcConnection) {
                $io->success('ODBC connection successful!');
                odbc_close($odbcConnection);
            } else {
                $io->error('ODBC connection failed: ' . odbc_errormsg());
            }
        } catch (\Exception $e) {
            $io->error('Connection failed: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}