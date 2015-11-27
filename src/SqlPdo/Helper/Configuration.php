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

}
