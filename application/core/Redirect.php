<?php

/**
 * Class Redirect
 *
 * Simple abstraction for redirecting the user to a certain page
 */
class Redirect {

    /**
     * To the homepage
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     */
    public static function home() {
        header("location: " . Config::get('URL', 'gen'));
    }

    /**
     * To the defined page
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     * @param $path
     */
    public static function to($path) {
        header("location: " . Config::get('URL', 'gen') . $path);
    }

}
