<?php

class Text
{
    private static $texts;

    /**
     * Name: get
     * Description:
     * returns the associated value in the associated array in the configuration file of texts.php
     * @author FRAMEWORK
     * @Date ?
     * @param type $key
     * @return type
     */
    public static function get($key)
    {
        if (!self::$texts) {
            self::$texts = require('../application/config/texts.php');
        }

        return self::$texts[$key];
    }

}
