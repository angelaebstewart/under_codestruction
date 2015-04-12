<?php

class Text
{
    private static $texts;

    /**
     * To the homepage
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
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
