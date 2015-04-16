<?php

/**
 * Class ChangePasswordModel
 *
 * Handles all the stuff that is related to the password change process
 */
class SetPinModel {

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
    public static function savePin($user_id, $user_pin_hash) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE codestructionuser
                   SET Pin = :user_pin_hash,
                       VerificationHash = NULL,
                       PasswordUpdated = 1,
                       Verified = 1
                 WHERE UserID = :user_id
                 LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':user_pin_hash' => $user_pin_hash, ':user_id' => $user_id
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
    public static function setNewPin($user_id, $user_pin_new, $user_pin_repeat) {
        if (empty($user_id)) {
            return false;
        } else if (empty($user_pin_new) || empty($user_pin_repeat)) {
            return false;
        } else if ($user_pin_new !== $user_pin_repeat) {
            return false;
        } else if (strlen($user_pin_new) != 4) {
            return false;
        }

        // crypt the user's password
        $user_pin_hash = RegistrationModel::hashPassword($user_pin_new);

        // write user's new password hash into database, reset user_password_reset_hash
        if (SetPinModel::savePin($user_id, $user_pin_hash)) {
            Session::add('feedback_positive', Text::get('FEEDBACK_PIN_SET_SUCCESSFUL'));
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_PIN_SET_FAILED'));
        return false;
    }
    

}
