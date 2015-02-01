<?php

/*
 * The Config will reload the array each time a configuration needs to be obtained
 * This is not great performace for the long run, need to think of a way to do 
 * this more efficiently.  
 */
class Config {
    public static function get($key, $configType = null) {
        if (isset($configType)) {
            $fileName = '../application/config/' . $configType . '.config.php';

            if (file_exists($fileName)) {
                $config = require($fileName);
                try{
                $result = $config[$key];
                //Will this catch an undefined index exception?
                } catch(ErrorException $e){
                    echo $e->getMessage();
                    return null;
                }
                return $result;
            }
        }
    }
}
    