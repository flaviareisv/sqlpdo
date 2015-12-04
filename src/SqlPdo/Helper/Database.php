<?php
namespace SqlPdo\Helper;

use SqlPdo\Helper\Configuration;

class Database {

    function getConn(Configuration $conf)
    {
        $conn = null;
        $str_con = $conf->getConfigDB();
        $cfg = new \Doctrine\DBAL\Configuration();

        if (count($str_con) > 0) {
            $conParams = array(
                'dbname' => $str_con['dbname'],
                'user' => $str_con['user'],
                'password' => $str_con['password'],
                'host' => $str_con['host'],
                'driver' => $str_con['driver']
            );
            $conn = \Doctrine\DBAL\DriverManager::getConnection($conParams, $cfg);
        }

        return $conn;
    }

    function isEstablished(Configuration $conf)
    {
        $isCon = self::getConn($conf)->connect();
        return $isCon;
    }

}
