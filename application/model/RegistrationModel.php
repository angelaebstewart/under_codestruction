<?php

/**
 * Class RegistrationModel
 *
 * Everything registration-related happens here.
 */
require_once ('../vendor/phpass-0.3/PasswordHash.php');

class RegistrationModel {

    /**
     * Name: registerNewUser
     * Description:
     * Handles the entire registration process for DEFAULT users and 
     * creates a new user in the database if everything is fine
     * @author FRAMEWORK (last-modified: Walter Conway)
     * @Date 4/12/2015
     * @param type $user_firstName
     * @param type $user_lastName
     * @param type $user_email
     * @param type $user_password_new
     * @param type $user_type
     * @return boolean
     */
    public static function registerNewUser($user_firstName, $user_lastName, $user_email, $user_password_new, $user_type ) {
        //$user_password_hash = $pwdHasher->HashPassword($user_password_new);
        $user_password_hash = RegistrationModel::hashPassword($user_password_new);

        // check if email already exists
        if (AccountModel::doesEmailAlreadyExist($user_email)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USER_EMAIL_ALREADY_TAKEN'));
            return false;
        }

        // generate random hash for email verification (40 char string)
        $user_activation_hash = RegistrationModel::generateActivationHash();

        // write user data to database
        $user_id = RegistrationModel::writeNewUserToDatabase($user_firstName, $user_lastName, $user_email, $user_password_hash, $user_activation_hash, $user_type);
        if ($user_id < 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_CREATION_FAILED'));
        }

        // send verification email
        if (RegistrationModel::sendVerificationEmail($user_id, $user_email, $user_activation_hash)) {
            return true;
        }

        // if verification email sending failed: instantly delete the user
        RegistrationModel::rollbackRegistrationByUserId($user_id);
        Session::add('feedback_negative', Text::get('FEEDBACK_VERIFICATION_MAIL_SENDING_FAILED'));
        return false;
    }

    /**
     * Name: registrationInputValidation
     * Description:
     * Validates the registration input
     * @author FRAMEWORK (modified: Walter Conway)
     * @Date 4/12/2015
     * @param $captcha
     * @param $user_name
     * @param $user_password_new
     * @param $user_password_repeat
     * @param $user_email
     * @return bool
     * NOTE: Not sure about keeping all this session stuff here in the model, but right now it is fine.
     */
    public static function registrationInputValidation($captcha, $user_firstName, $user_lastName, $user_email, $user_password_new, $user_password_repeat) {
        // perform all necessary checks
        if (!CaptchaModel::checkCaptcha($captcha)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_CAPTCHA_WRONG'));
        } else if (empty($user_firstName) OR empty($user_lastName)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_FIELD_EMPTY'));
        } else if (empty($user_password_new) OR empty($user_password_repeat)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_FIELD_EMPTY'));
        } else if ($user_password_new !== $user_password_repeat) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_REPEAT_WRONG'));
        } else if (strlen($user_password_new) < 6) {
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_TOO_SHORT'));
        } else if (empty($user_email)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_EMAIL_FIELD_EMPTY'));
        } else if (strlen($user_email) > 254) {
            // @see http://stackoverflow.com/questions/386294/what-is-the-maximum-length-of-a-valid-email-address
            Session::add('feedback_negative', Text::get('FEEDBACK_EMAIL_TOO_LONG'));
        } else if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN'));
        } else if (strpos($user_email, ".edu") === FALSE) {
            Session::add('feedback_negative', Text::get('FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN'));
        } else {
            return true;
        }
        return false;
    }

    /**
     * Name: writeNewUserToDatabase
     * Description:
     * Writes the new user's data to the database
     * @author Ethan Mata and Victoria Richardson
     * @Date ?
     * @param $user_name
     * @param $user_password_hash
     * @param $user_email
     * @param $user_creation_timestamp
     * @param $user_activation_hash
     * @return bool
     * Note: Later on try and take out manually incrementing the user id and do autoincrement using 
     * SQL. This will lead to race conditions if not remedied. 
     */
    public static function writeNewUserToDatabase($user_firstName, $user_lastName, $user_email, $user_password_hash, $user_activation_hash, $user_type) {
        $database = DatabaseFactory::getFactory()->getConnection();

        // write new users data into database
        $sql2 = "SELECT MAX(User.UserID) AS new_id FROM codestructionuser User";
        $query2 = $database->prepare($sql2);
        $query2->execute();
        $results = $query2->fetchAll();
        $user_id = $results[0]->new_id;
        $user_id += 1;
        $sql = "INSERT INTO codestructionuser (FirstName, LastName, Email, UserID, PasswordHash, VerificationHash, Type, Verified, PasswordUpdated, isValid) 
                        VALUES (:user_firstName, :user_lastName, :user_email, :user_id,:user_password_hash, :user_activation_hash, :user_type, 0, 0, 1)";
        $query = $database->prepare($sql);
        $query->execute(array(':user_firstName' => $user_firstName,
            ':user_lastName' => $user_lastName,
            ':user_email' => $user_email,
            ':user_id' => $user_id,
            ':user_password_hash' => $user_password_hash,
            ':user_activation_hash' => $user_activation_hash,
            ':user_type' => $user_type,));
        $count = $query->rowCount();
        

        $sql = "INSERT INTO codestructionloginattempt(UserID) VALUES (:user_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id,));

        //LoginModel::createLoginRecordForStudent($user_id);
        if ($count > 0) {
            return $user_id;
        }
        return -1;
    }

    /**
     * Name: hasPassword
     * Description:
     * Creates the password hash.
     * @author FRAMEWORK
     * @Date ?
     * @param type $user_password_new
     */
    public static function hashPassword($user_password_new) {
        $pwdHasher = new PasswordHash(Config::get("HASH_COST_LOG2", 'gen'), Config::get("HASH_PORTALBE", 'gen'));
        return $pwdHasher->HashPassword($user_password_new);
    }

    /**
     * Name: generateActivationHash
     * Description:
     * Generates the user's activation hash
     * @author FRAMEWORK
     * @Date ?
     * @return type
     */
    public static function generateActivationHash() {
        return sha1(uniqid(mt_rand(), true));
    }

    /**
     * Name: rollbackRegistrationByUserId
     * Description:
     * Deletes the user from users table. Currently used to rollback a registration when verification mail sending
     * was not successful.
     * @author FRAMEWORK
     * @Date ?
     * @param $user_id
     */
    public static function rollbackRegistrationByUserId($user_id) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("DELETE FROM codestructionuser WHERE UserID = :user_id");
        $query->execute(array(':user_id' => $user_id));
    }

    /**
     * Name: sendVerificationEmail
     * Description:
     * Sends the verification email (to confirm the account)
     * @author FRAMEWORK
     * @Date ?
     * @param int $user_id user's id
     * @param string $user_email user's email
     * @param string $user_activation_hash user's mail verification hash string
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
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
            Session::add('feedback_positive', Text::get('FEEDBACK_VERIFICATION_MAIL_SENDING_SUCCESSFUL'));
            return true;
        } else {
            Session::add('feedback_negative', Text::get('FEEDBACK_VERIFICATION_MAIL_SENDING_ERROR') . $mail->getError());
            return false;
        }
    }

    /**
     * Name: verifyNewUser
     * Description:
     * checks the email/verification code combination and set the user's activation status to true in the database
     * @author FRAMEWORK
     * @Date ?
     * @param int $user_id user id
     * @param string $user_activation_hash verification token
     * @return bool success status
     */
    public static function verifyNewUser($user_id, $user_activation_hash) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE codestructionuser SET verified = 1, VerificationHash = NULL
                WHERE UserID = '$user_id' AND VerificationHash = '$user_activation_hash' LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':user_activation_hash' => $user_activation_hash));

        if ($query->rowCount() == 1) {
            return true;
        }
        return false;
    }
}
