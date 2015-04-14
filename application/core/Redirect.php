<?php

/**
 * Class Redirect
 *
 * Simple abstraction for redirecting the user to a certain page
 */
class Redirect {

    /**
     * Name: home
     * Description:
     * To the homepage
     * @author FRAMEWORK
     * @Date ?
     */
    public static function home() {
        header("location: " . Config::get('URL', 'gen'));
    }

    /**
     * Name: to
     * Description:
     * To the defined page
     * @author FRAMEWORK
     * @Date ?
     * @param $path the path of the page that chosen to be direct to.
     */
    public static function to($path) {
        header("location: " . Config::get('URL', 'gen') . $path);
    }

}
