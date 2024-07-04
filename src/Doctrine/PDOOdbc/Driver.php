<?php 

namespace App\Doctrine\Driver\PDOOdbc;

use Doctrine\DBAL\Driver\AbstractDriver;
use Doctrine\DBAL\Driver\PDO\Connection;
use Doctrine\DBAL\Platforms\SQLServerPlatform;
use Doctrine\DBAL\Schema\SQLServerSchemaManager;

class Driver extends AbstractDriver
{
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        $dsn = $this->constructPdoDsn($params);
        return new Connection(new \PDO($dsn, $username, $password, $driverOptions));
    }

    protected function constructPdoDsn(array $params)
    {
        return 'odbc:' . $params['dsn'];
    }

    public function getDatabasePlatform()
    {
        return new SQLServerPlatform();
    }

    public function getSchemaManager(\Doctrine\DBAL\Connection $conn)
    {
        return new SQLServerSchemaManager($conn);
    }

    public function getName()
    {
        return 'pdo_odbc';
    }
}
