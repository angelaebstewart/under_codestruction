<?php

/*
 * The Config will reload the array each time a configuration needs to be obtained
 * This is not great performace for the long run, need to think of a way to do 
 * this more efficiently.  
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
