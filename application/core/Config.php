<?php

/*
 * fixed the configuration file so it will be a little faster since it won't have 
 * to reload an array list each time it is used. If the array list was just used 
 * it won't have to reload it, but if the array list was replaced with another list 
 * and then it would have to replace it again. Will have to maybe optimize this by 
 * having an associative array to perform a lookup of the configuration file to see 
 * if it has even been called and if it has to return that array. This will be done 
 * later.
 */

class Config {

    private static $configArray = null;
    private static $configurationType = '';

    public static function get($key, $configType = null) {
        //No configType set so no reason to go any further
        if (isset($configType)) {
            /*
             * If this is false then this means this is the first
             * execution, it may or may not be successful
             */
            if (isset(self::$configurationType)) {

                if (self::$configurationType == $configType) {
                    return self::$configArray[$key];
                } else {
                    if (self::loadConfigurationFile($configType)) {
                        return self::$configArray[$key];
                    }
                }
            } else {
                if (self::loadConfigurationFile($configType)) {
                    return self::$configArray[$key];
                }
            }
        }
    }
    /**
     * Loads the static configuration variable if the file is avaliable
     *
     * @param $configType Configuration Type of the configuration trying to access
     *
     * @return bool success status
     */
    private static function loadConfigurationFile($configType) {
        $fileName = '../application/config/' . $configType . '.config.php';
        if (file_exists($fileName)) {
            self::$configurationType = $configType;
            self::$configArray = require($fileName);
            return true;
        }
        return false;
    }

}
