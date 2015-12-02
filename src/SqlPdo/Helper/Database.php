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
        $cons = Configuration::getConfig('pdo');

        if (count($cons) > 0) {
            foreach ($cons as $con_str) {
                if ($con_str['nome'] == $name) {
                    $this->dbname = $con_str['dbname'];
                    $this->user = $con_str['user'];
                    $this->password = $con_str['password'];
                    $this->host = $con_str['host'];
                    $this->driver = $con_str['driver'];
                }
            }
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
