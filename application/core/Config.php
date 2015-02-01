<?php

class Config {

    private static $config;

    public static function get($key, $configType = null) {
        if (isset($configType)) {
            $fileName = '../application/config/' . $configType . '.config.php';

            if (file_exists($fileName)) {
                if (!self::$config) {
                    self::$config = require($fileName);
                }
                return self::$config[$key];
            }
        }
    }
}
    