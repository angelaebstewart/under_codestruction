<?php

/*
 * Configuration fetcher.
 */

class Config {

    private static $configArrayRepository = array();
    private static $configArray;

    /**
     * Name: get
     * Description:
     * Fetches the requested configuration from the specified configuration file.
     * @author Walter Conway
     * @Date 2/11/2015
     * @param  string $key The key of the value in the configuration.
     * @param string $configType The type of configuration that you want
     * @return mixed The value of the key of the configuration specified, if it is available.
     */
    public static function get($key, $configType = null) {
        //No configType set so no reason to go any further
        if (isset($configType)) {
            $doesConfigKeyExist = array_key_exists($configType, self::$configArrayRepository);
            if ($doesConfigKeyExist) {
                $doesKeyExistInConfig = array_key_exists($key, self::$configArrayRepository[$configType]);
                if ($doesKeyExistInConfig) {
                    return self::$configArrayRepository[$configType][$key];
                }
            } else {
                $fileName = realpath(dirname(__FILE__) . '/../../') . '/application/config/' . $configType . '.config.php';
                $fileExist = file_exists($fileName);
                if ($fileExist) {
                    $newAssociativeArray = array($configType => require($fileName));
                    self::$configArrayRepository = array_merge(self::$configArrayRepository, $newAssociativeArray);

                    $doesKeyExistInConfig = array_key_exists($key, self::$configArrayRepository[$configType]);
                    if ($doesKeyExistInConfig) {
                        return self::$configArrayRepository[$configType][$key];
                    }
                }
            }
        }
    }

}
