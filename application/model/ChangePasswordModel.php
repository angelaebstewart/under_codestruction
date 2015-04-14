<?php

/**
 * Class ChangePasswordModel
 *
 * Handles all the stuff that is related to the password change process
 */
class ChangePasswordModel {

    /**
     * Writes the new password to the database
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     * @param string $user_name username
     * @param string $user_password_hash
     * @param string $user_password_reset_hash
     *
     * @return bool
     */
    public static function saveNewUserPassword($user_id, $user_password_hash) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE codestructionuser
                   SET PasswordHash = :user_password_hash,
                       VerificationHash = NULL,
                       PasswordUpdated = 1,
                       Verified = 1
                 WHERE UserID = :user_id
                 LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user_password_hash' => $user_password_hash, ':user_id' => $user_id
        ));

        // if successful
        if ($query->rowCount() == 1) {
            return true;
        }
        return false;
    }

    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: setNewPassword
     * Description:
     * Set the new password (for DEFAULT user)
     * Please note: At this point the user has already pre-verified via verifyPasswordReset() (within one hour),
     * so we don't need to check again for the 60min-limit here. In this method we authenticate
     * via username & password-reset-hash from (hidden) form fields.
     * @author ?
     * @Date ?
     * @param string $user_name
     * @param string $user_password_new
     * @param string $user_password_repeat
     * @return bool success state of the password reset
     */
    public static function setNewPassword($user_id, $user_password_new, $user_password_repeat) {
        if (empty($user_id)) {
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
        if (ChangePasswordModel::saveNewUserPassword($user_id, $user_password_hash)) {
            Session::add('feedback_positive', Text::get('FEEDBACK_PASSWORD_CHANGE_SUCCESSFUL'));
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
        return false;
    }

}
