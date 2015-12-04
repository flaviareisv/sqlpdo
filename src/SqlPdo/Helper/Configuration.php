<?php
namespace SqlPdo\Helper;

class Configuration {
    private $nameConnection;

    function setNameCon($name)
    {
        $this->nameConnection = $name;
    }

    function getNameCon()
    {
        return $this->nameConnection;
    }

    function getConfig($task) {
        $out = array();
        $pathConfig = $_SERVER["HOME"].'/.config/sqlpdo/config';

        if (file_exists($pathConfig)) {
            $fileContent = file_get_contents($pathConfig);
            $config = json_decode($fileContent, true);
            $out = $config[$task];
        }

        return $out;
    }

    function getConfigDB() {
        $data = array();
        $cons = self::getConfig('pdo');

        if (count($cons) > 0) {
            foreach ($cons as $con_str) {
                if ($con_str['name'] == $this->nameConnection) 
                    $data = $con_str;
            }
        }

        return $data;
    }

}
