<?php

/**
 * Session class
 *
 * handles the session stuff. creates session when no one exists, sets and gets values, and closes the session
 * properly (=logout). Not to forget the check if the user is logged in or not.
 */
class Session
{
    /**
     * Name: init
     * Description:
     * starts the session
     * To the homepage
     * @author FRAMEWORK
     * @Date ?
     */
    public static function init()
    {
        // if no session exist, start the session
        if (session_id() == '') {
            session_start();
        }
    }

    /**
     * Name: set
     * Description:
     * sets a specific value to a specific key of the session
     * To the homepage
     * @author FRAMEWORK
     * @Date ?
     * @param mixed $key key
     * @param mixed $value value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Name: get
     * Description:
     * gets/returns the value of a specific key of the session
     * To the homepage
     * @author FRAMEWORK
     * @Date ?
     * @param mixed $key Usually a string, right ?
     * @return mixed the key's value or nothing
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    /**
     * Name: add
     * Description:
     * adds a value as a new array element to the key.
     * useful for collecting error messages etc
     * To the homepage
     * @author FRAMEWORK
     * @Date ?
     * @param mixed $key
     * @param mixed $value
     */
    public static function add($key, $value)
    {
        $_SESSION[$key][] = $value;
    }

    /**
     * Name: destroy
     * Description:
     * deletes the session (= logs the user out)
     * To the homepage
     * @author FRAMEWORK
     * @Date ?
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * Name: userIsLoggedIn
     * Description:
     * Checks if the user is logged in or not
     * To the homepage
     * @author FRAMEWORK
     * @Date ?
     * @return bool user's login status
     */
    public static function userIsLoggedIn()
    {
        return (Session::get('user_logged_in') ? true : false);
    }
}
