<?php
namespace SqlPdo\Helper;

class Configuration {
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

    function getConfigDB($name) {
        $data = array();
        $cons = self::getConfig('pdo');

        if (count($cons) > 0) {
            foreach ($cons as $con_str) {
                if ($con_str['name'] == $name) 
                    $data = $con_str;
            }
        }

        return $data;
    }

}
