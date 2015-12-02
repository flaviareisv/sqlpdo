<?php
namespace SqlPdo\Helper;

use SqlPdo\Helper\Configuration;

class Database {
    private $dbname;
    private $user;
    private $password;
    private $host;
    private $driver;

    function __construct($name)
    {
        $conn = Configuration::getConfigDB($name);

        if (count($conn) > 0) {
            $this->dbname = $conn['dbname'];
            $this->user = $conn['user'];
            $this->password = $conn['password'];
            $this->host = $conn['host'];
            $this->driver = $conn['driver'];
        }
    }

    function getConn()
    {
        $cfg = new \Doctrine\DBAL\Configuration();
        $conParams = array(
            'dbname' => $this->dbname,
            'user' => $this->user,
            'password' => $this->password,
            'host' => $this->host,
            'driver' => $this->driver
        );
        $conn = \Doctrine\DBAL\DriverManager::getConnection($conParams, $cfg);

        return $conn;
    }
}
