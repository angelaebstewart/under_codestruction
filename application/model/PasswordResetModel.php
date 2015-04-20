<?php

/**
 * Class PasswordResetModel *
 * 
 * Handles all the logic that is related to the password-reset process
 */
class PasswordResetModel {

    /**
     * Name: requestPasswordReset
     * Description:
     * Perform the necessary actions to send a password reset mail
     * @author FRAMEWORK (modified by: Walter Conway)
     * @Date ?
     * @param $email user's email
     * @return bool success status
     */
    public static function requestPasswordReset($email) {

        // check if that email exists
        $result = AccountModel::getUserIdByEmail($email);
        if ($result == -1) {
            return false;
        }
        // generate random hash for email password reset verification (40 char string)
        $user_password_reset_hash = sha1(uniqid(mt_rand(), true));
        $token_set = PasswordResetModel::setPasswordResetDatabaseToken($result, $user_password_reset_hash);
        if (!$token_set) {
            return false;
        }

        // ... and send a mail to the user, containing a link with userid and token hash string
        $mail_sent = PasswordResetModel::sendPasswordResetMail($result, $user_password_reset_hash, $result);
        if ($mail_sent) {
            return true;
        }

        // default return
        return false;
    }

    /**
     * Name: setPasswordResetDatabaseToken
     * Description:
     * Set password reset token in database
     * @author FRAMEWORK (modified by: Walter Conway)
     * @Date ?
     * @param string $user_id user id
     * @param string $user_password_reset_hash password reset hash
     * @param int $temporary_timestamp timestamp
     * @return bool success status
     */
    public static function setPasswordResetDatabaseToken($user_id, $user_password_reset_hash) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE codestructionuser SET ResetHash = :user_password_reset_hash, PasswordUpdated = 0 WHERE UserID = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_password_reset_hash' => $user_password_reset_hash, ':user_id' => $user_id));

        // check if exactly one row was successfully changed
        if ($query->rowCount() == 1) {
            return true;
        }
        return false;
    }

    /**
     * Name: sendPasswordResetMail
     * Description:
     * Send the password reset mail
     * @author FRAMEWORK (modified by: Walter Conway)
     * @Date ?
     * @param string $user_id userid
     * @param string $user_password_reset_hash password reset hash
     * @param string $user_email user email
     * @return bool success status
     */
    public static function sendPasswordResetMail($user_id, $user_password_reset_hash, $user_email) {
        // create email body
        $body = Config::get('EMAIL_PASSWORD_RESET_CONTENT', 'email') . ' ' . Config::get('URL', 'gen') .
                Config::get('EMAIL_PASSWORD_RESET_URL', 'email') . '/' . urlencode($user_id) . '/' .
                urlencode($user_password_reset_hash);

        // create instance of Mail class, try sending and check
        $mail = new Mail;
        $mail_sent = $mail->sendMail(
                $user_email, Config::get('EMAIL_PASSWORD_RESET_FROM_EMAIL', 'email'), Config::get('EMAIL_PASSWORD_RESET_FROM_NAME', 'email'), Config::get('EMAIL_PASSWORD_RESET_SUBJECT', 'email'), $body
        );

        if ($mail_sent) {
            return true;
        }
        return false;
    }

    /**
     * Name: verifyPasswordReset
     * Description:
     * Verifies the password reset request via the verification hash token (that's only valid for one hour)
     * @author FRAMEWORK
     * @Date ?
     * @param string $user_id User id
     * @param string $verification_code Hash token
     * @return bool Success status
     */
    public static function verifyPasswordReset($user_id, $verification_code) {
        $database = DatabaseFactory::getFactory()->getConnection();

        // check if user-provided userid + verification code combination exists
        $sql = "SELECT UserID
                  FROM codestructionuser
                 WHERE UserID = :user_id
                       AND ResetHash = :user_password_reset_hash
                 LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user_password_reset_hash' => $verification_code, ':user_id' => $user_id
        ));

        // if this user with exactly this verification hash code does NOT exist
        if ($query->rowCount() != 1) {
            return false;
        }
        return true;
    }

    /**
     * Name: saveNewUserPassword
     * Description:
     * Writes the new password to the database
     * @author FRAMEWORK
     * @Date ?
     * @param string $user_id user id
     * @param string $user_password_hash
     * @param string $user_password_reset_hash
     * @return bool
     */
    public static function saveNewUserPassword($user_id, $user_password_hash, $user_password_reset_hash) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE codestructionuser
                   SET PasswordHash = :user_password_hash,
                       ResetHash = NULL,
                       PasswordUpdated = 1,
                       Verified = 1
                 WHERE UserID = :user_id
                       AND ResetHash = :user_password_reset_hash
                 LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user_password_hash' => $user_password_hash, ':user_id' => $user_id,
            ':user_password_reset_hash' => $user_password_reset_hash
        ));

        // if successful
        if ($query->rowCount() == 1) {
            return true;
        }
        return false;
    }

    /**
     * Name: setNewPassword
     * Description:
     * Set the new password (for DEFAULT user)
     * Please note: At this point the user has already pre-verified via verifyPasswordReset() (within one hour),
     * so we don't need to check again for the 60min-limit here. In this method we authenticate
     * via user id & password-reset-hash from (hidden) form fields.
     * @author FRAMEWORK
     * @Date ?
     * @param string $user_id
     * @param string $user_password_reset_hash
     * @param string $user_password_new
     * @param string $user_password_repeat
     * @return bool success state of the password reset
     */
    public static function setNewPassword($user_id, $user_password_reset_hash, $user_password_new, $user_password_repeat) {
        if (empty($user_id)) {
            return false;
        } else if (empty($user_password_reset_hash)) {
            return false;
        } else if (empty($user_password_new) || empty($user_password_repeat)) {
            return false;
        } else if ($user_password_new !== $user_password_repeat) {
            return false;
        } else if (strlen($user_password_new) < 6) {
            return false;
        }

        // crypt the user's password
        $user_password_hash = RegistrationModel::hashPassword($user_password_new);

        // write user's new password hash into database, reset user_password_reset_hash
        if (PasswordResetModel::saveNewUserPassword($user_id, $user_password_hash, $user_password_reset_hash)) {
            return true;
        }
        return false;
    }

}
