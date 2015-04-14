<?php

/**
 * Class Auth
 * Checks if user is logged in, if not then sends the user to "yourdomain.com/login".
 * Auth::checkAuthentication() can be used in the constructor of a controller (to make the
 * entire controller only visible for logged-in users) or inside a controller-method to make only this part of the
 * application available for logged-in users.
 */
class Auth {

    /**
     * Name: checkAuthentication
     * Description:
     * Checks if the user is logged in and if the user is not then it deletes the user session
     * data and then directs them to the login page, without returning to original statment that called it.
     * This is where exit() comes in.
     * @author FRAMEWORK (modified by:Walter Conway, used redirect instead of header.)
     * @Date 4/14/2015
     */
    public static function checkAuthentication() {
        // initialize the session (if not initialized yet)
        Session::init();

        // if user is not logged in...
        if (!Session::userIsLoggedIn()) {
            // ... then treat user as "not logged in", destroy session, redirect to login page
            Session::destroy();
            Redirect::to("login/index");
            // to prevent fetching views via cURL (which "ignores" the header-redirect above) we leave the application
            // the hard way, via exit(). @see https://github.com/panique/php-login/issues/453
            // this is not optimal and will be fixed in future releases
            exit();
        }
    }

}
