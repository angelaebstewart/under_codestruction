<?php

/**
 * LoginModel
 *
 * The login part of the model: Handles the login / logout stuff
 */
require ('../vendor/phpass-0.3/PasswordHash.php');
class LoginModel
{
    /**
     * Login process (for DEFAULT user accounts).
     *
     * @param $user_name string The user's name
     * @param $user_password string The user's password
     * 
     * @return bool success state
     */
    public static function login($user_name, $user_password)
    {
        $pwdHasher = new PasswordHash(Config::get("HASH_COST_LOG2"), Config::get("HASH_PORTALBE"));
        // we do negative-first checks here, for simplicity empty username and empty password in one line
        if (empty($user_name) OR empty($user_password)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_OR_PASSWORD_FIELD_EMPTY'));
            return false;
        }

        // get all data of that user (to later check if password and password_hash fit)
        $result = UserModel::getUserDataByUsername($user_name);

        // Check if that user exists. We don't give back a cause in the feedback to avoid giving an attacker details.
        if (!$result) {
            Session::add('feedback_negative', Text::get('FEEDBACK_LOGIN_FAILED'));
            return false;
        }

        // hash of provided password does NOT match the hash in the database
        if (!$pwdHasher->CheckPassword($user_password, $result->passwordHash)) {
            // we say "password wrong" here, but less details like "login failed" would be better (= less information)
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_WRONG'));
            return false;
        }

        // from here we assume that the password hash fits the database password hash, as password_verify() was true

        // if user is not active (= has not verified account by verification mail)
        if ($result->verified != 1) {
            Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_NOT_ACTIVATED_YET'));
            return false;
        }

        // successfully logged in, so we write all necessary data into the session and set "user_logged_in" to true
        LoginModel::setSuccessfulLoginIntoSession(
            $result->uid, $result->FirstName, $result->LastName, $result->Email, $result->Role
        );

        // return true to make clear the login was successful
        // maybe do this in dependence of setSuccessfulLoginIntoSession ?
        return true;
    }

    /**
     * Log out process: delete session
     */
    public static function logout()
    {
        Session::destroy();
    }

    /**
     * The real login process: The user's data is written into the session.
     * Cheesy name, maybe rename. Also maybe refactoring this, using an array.
     *
     * @param $user_id
     * @param $user_firstName
     * @param $user_lastName
     * @param $user_email
     * @param $user_role
     */
    public static function setSuccessfulLoginIntoSession($user_id, $user_firstName, $user_lastName, $user_email, $user_role)
    {
        Session::init();
        Session::set('user_id', $user_id);
        Session::set('user_firstName', $user_firstName);
        Session::set('user_lastName', $user_lastName);
        Session::set('user_email', $user_email);
        Session::set('user_logged_in_role', $user_role);
        Session::set('user_provider_type', 'DEFAULT');

        Session::set('user_logged_in', true);
    }

    /**
     * Returns the current state of the user's login
     *
     * @return bool user's login status
     */
    public static function isUserLoggedIn()
    {
        return Session::userIsLoggedIn();
    }
}
