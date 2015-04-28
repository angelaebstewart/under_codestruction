<?php

/**
 * LoginModel
 *
 * The login part of the model: Handles the login / logout stuff
 */
require_once ('../vendor/phpass-0.3/PasswordHash.php');

class LoginModel {

    /**
     * Name: login
     * Description:
     * Login process.
     * @author FRAMEWORK
     * @Date ?
     * @param $user_name string The user's name
     * @param $user_password string The user's password
     * @return bool success state
     */
    public static function login($user_email, $user_password) {
        $pwdHasher = new PasswordHash(Config::get("HASH_COST_LOG2", 'gen'), Config::get("HASH_PORTALBE", 'gen'));
        // we do negative-first checks here, for simplicity empty username and empty password in one line
        if (empty($user_email) OR empty($user_password)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_OR_PASSWORD_FIELD_EMPTY'));
            return false;
        }

        // get all data of that user (to later check if password and password_hash fit)
        $result = AccountModel::getUserDataByEmail($user_email);

        // Check if that user exists. We don't give back a cause in the feedback to avoid giving an attacker details.
        if (!$result) {
            Session::add('feedback_negative', Text::get('FEEDBACK_LOGIN_FAILED'));
            return false;
        }
        
        // Check to make sure that the user account has not been deactivated
        if ($result->IsValid == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_LOGIN_FAILED'));
            return false;
        }
        
        
        // hash of provided password does NOT match the hash in the database
        if (!$pwdHasher->CheckPassword($user_password, $result->passwordHash)) {
            // we say "password wrong" here, but less details like "login failed" would be better (= less information)
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_WRONG'));

            //increments the login in lock out
            $userID = $result->UserID;
            LoginModel::invalidLogin($userID);

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
                $result->UserID, $result->FirstName, $result->LastName, $result->Email, $result->Type
        );

        // return true to make clear the login was successful
        // maybe do this in dependence of setSuccessfulLoginIntoSession ?
        return true;
    }

    /**
     * Name: validLogin
     * Description:
     * For a valid login attempt, this will reset the AttemptNumber in the database to 0
     * so that the next time the user logs in the counter of errors will start at 0. 
     * @author FRAMEWORK
     * @Date ?
     * @param type $userID
     */
    public static function validLogin($userID) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE codestructionloginattempt SET AttemptNumber = 0 WHERE UserID = '$userID' LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute();
    }

    /**
     * Name: invalidLogin
     * Description:
     * This will be called in the event of an invalid login attempt. It will increment the 
     * AttemptNumber everytime a login fails.
     * @author Victoria Richardson & Ethan Mata
     * @Date ?
     * @param type $userID
     */
    public static function invalidLogin($userID) {

        $database = DatabaseFactory::getFactory()->getConnection();

        $getAttempt = "SELECT AttemptNumber AS attempt FROM codestructionloginattempt WHERE UserID = '$userID'";
        $query2 = $database->prepare($getAttempt);
        $query2->execute();
        $results = $query2->fetchAll();
        $newAttempt = $results[0]->attempt;
        $newAttempt += 1;

        //Lock out goes here if the $newAttempt equals 10
        if ($newAttempt < 10) {
            $updateAttempt = "UPDATE codestructionloginattempt SET AttemptNumber = :attempt_number WHERE UserID = '$userID'";
            $query = $database->prepare($updateAttempt);
            $query->execute(array(':attempt_number' => $newAttempt,));
        } else {

            $user_activation_hash = sha1(uniqid(mt_rand(), true));
            //get user email
            $sql = "SELECT Email as email FROM codestructionuser WHERE UserID = :user_id LIMIT 1";
            $query = $database->prepare($sql);
            $query->execute(array(':user_id' => $userID));
            $results = $query->fetchAll();
            $user_email = $results[0]->email;

            
            if (!PasswordResetModel::sendPasswordResetMail($userID, $user_activation_hash, $user_email)) {
                return false;
            }
            
            $updateValid = "UPDATE codestructionuser SET ResetHash = :VerificationHash, Verified = 0 WHERE UserID = '$userID'";
            $query = $database->prepare($updateValid);
            $query->execute(array(':VerificationHash' => $user_activation_hash,));

            LoginModel::validLogin($userID);
        }
    }

    /**
     * Name: sendVerificationEmail
     * Description:
     * Same function as in RegistrationModel, but moved for PasswordHash issues
     * @author FRAMEWORK
     * @Date ?
     * @param type $user_id
     * @param type $user_email
     * @param type $user_activation_hash
     * @return boolean
     */
    public static function sendVerificationEmail($user_id, $user_email, $user_activation_hash) {
        // create email body
        $body = Config::get('EMAIL_VERIFICATION_CONTENT', 'email') . Config::get('URL', 'gen') . Config::get('EMAIL_VERIFICATION_URL', 'email')
                . '/' . urlencode($user_id) . '/' . urlencode($user_activation_hash);

        // create instance of Mail class, try sending and check
        $mail = new Mail;
        $mail_sent = $mail->sendMail(
                $user_email, Config::get('EMAIL_VERIFICATION_FROM_EMAIL', 'email'), Config::get('EMAIL_VERIFICATION_FROM_NAME', 'email'), Config::get('EMAIL_VERIFICATION_SUBJECT', 'email'), $body
        );

        if ($mail_sent) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_VERIFICATION_MAIL_SENDING_ERROR') . $mail->getError());
        return false;
    }

    /**
     * Name: logout
     * Description:
     * Log out process: delete session
     * @author FRAMEWORK
     * @Date ?
     */
    public static function logout() {
        Session::destroy();
    }

    /**
     * Name: setSuccessfulLoginIntoSession
     * Description:
     * The real login process: The user's data is written into the session.
     * @author FRAMEWORK
     * @Date ?
     * @param $user_id
     * @param $user_firstName
     * @param $user_lastName
     * @param $user_email
     * @param $user_role
     */
    public static function setSuccessfulLoginIntoSession($user_id, $user_firstName, $user_lastName, $user_email, $user_role) {
        Session::init();
        Session::set('user_id', $user_id);
        Session::set('user_firstName', $user_firstName);
        Session::set('user_lastName', $user_lastName);
        Session::set('user_email', $user_email);
        Session::set('user_role', $user_role);
        Session::set('user_provider_type', 'DEFAULT');

        Session::set('user_logged_in', true);
    }

    /*
     * Name: createLoginRecordForStudent
     * Description:
     * Creates a login attempt record for a new student
     * @author Ethan Mata
     * @Date 4/6/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int $userID The userID to create a record for
     * @return Boolean, whether the query succeeded
     */

    public static function createLoginRecordForStudent($user_id) {
        if (!isset($user_id)) {
            throw new InvalidArgumentException("Invalid Parameters");
        }

        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "INSERT INTO codestructionloginattempt(UserID) 
                        VALUES (:user_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id,));
        $result = $query->fetch();

        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }
}
