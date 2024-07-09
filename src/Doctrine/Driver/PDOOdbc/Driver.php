<?php

namespace App\Doctrine\Driver\PDOOdbc;

use Doctrine\DBAL\Driver\AbstractDriver;
use Doctrine\DBAL\Driver\PDO\Connection;
use Doctrine\DBAL\Platforms\SQLServerPlatform;
use Doctrine\DBAL\Schema\SQLServerSchemaManager;
use Doctrine\DBAL\Driver\PDO\Exception;

class Driver extends AbstractDriver
{
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        $dsn = $this->constructPdoDsn($params);
        try {
            return new Connection(new \PDO($dsn, $username, $password, $driverOptions));
        } catch (\PDOException $e) {
            throw Exception::new($e);
        }
    }

    protected function constructPdoDsn(array $params)
    {
        return 'odbc:' . $params['Data'];
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


