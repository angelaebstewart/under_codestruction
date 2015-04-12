<?php

/**
 * Class ChangeEmailModel
 *
 * Handles all the stuff that is related to the email change process
 */

class ChangeEmailModel
{
	/**
	 * Perform the necessary actions to send an email reset mail
	 *
	 * @param $email user's email
	 *
	 * @return bool success status
	 */
	public static function requestEmailReset($email, $new_user_name)
	{
                //Check if email is current user
                $currentUser = Session::get('user_email');
                if ($currentUser != $email)
                {
                    Session::add('feedback_negative', Text::get('FEEDBACK_WRONG_EMAIL'));
                    return false;
                }       
                        
		// check if that username exists
		$result = AccountModel::getUserIdByEmail($email);
		if ($result == -1) {
			Session::add('feedback_negative', Text::get('FEEDBACK_USER_DOES_NOT_EXIST'));
			return false;
		}
                
                if (AccountModel::doesEmailAlreadyExist($new_user_name)) {
			Session::add('feedback_negative', Text::get('FEEDBACK_USER_EMAIL_ALREADY_TAKEN'));
			return false;
		}

		// generate integer-timestamp (to see when exactly the user (or an attacker) requested the password reset mail)
		// generate random hash for email password reset verification (40 char string)
		$user_password_reset_hash = sha1(uniqid(mt_rand(), true));

                
		$token_set = ChangeEmailModel::setEmailResetDatabaseToken($result, $user_password_reset_hash);
		if (!$token_set) {
			return false;
		}

		// ... and send a mail to the user, containing a link with username and token hash string
		$mail_sent = ChangeEmailModel::sendEmailResetMail($result, $user_password_reset_hash, $new_user_name);
		if ($mail_sent) {
			return true;
		}

		// default return
		return false;
	}

	/**
	 * Set password reset token in database
	 *
	 * @param string $user_name username
	 * @param string $user_password_reset_hash password reset hash
	 * @param int $temporary_timestamp timestamp
	 *
	 * @return bool success status
	 */
	public static function setEmailResetDatabaseToken($user_id, $user_password_reset_hash)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "UPDATE codestructionuser SET VerificationHash = :user_password_reset_hash, PasswordUpdated = 0 WHERE UserID = :user_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':user_password_reset_hash' => $user_password_reset_hash, ':user_id' => $user_id));

		// check if exactly one row was successfully changed
		if ($query->rowCount() == 1) {
			return true;
		}
		return false;
	}

	/**
	 * Send the email reset mail
	 *
	 * @param string $user_id userid
	 * @param string $user_password_reset_hash password reset hash
	 * @param string $user_email user email
	 *
	 * @return bool success status
	 */
	public static function sendEmailResetMail($user_id, $user_password_reset_hash, $user_email)
	{
		// create email body
		$body = Config::get('EMAIL_EMAIL_RESET_CONTENT','email') . ' ' . Config::get('URL','gen') .
		        Config::get('EMAIL_EMAIL_RESET_URL','email') . '/' . urlencode($user_id) . '/' .
		        urlencode($user_password_reset_hash). '/' . urlencode($user_email) ;

		// create instance of Mail class, try sending and check
		$mail = new Mail;
		$mail_sent = $mail->sendMail(
			$user_email,
			Config::get('EMAIL_EMAIL_RESET_FROM_EMAIL','email'),
			Config::get('EMAIL_EMAIL_RESET_FROM_NAME','email'),
			Config::get('EMAIL_EMAIL_RESET_SUBJECT','email'),
			$body
		);

		if ($mail_sent) {
			//Session::add('feedback_positive', Text::get('FEEDBACK_PASSWORD_RESET_MAIL_SENDING_SUCCESSFUL'));
			return true;
		}

		//Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_MAIL_SENDING_ERROR') . $mail->getError() );
		return false;
	}

	/**
	 * Verifies the password reset request via the verification hash token (that's only valid for one hour)
	 * @param string $user_name Username
	 * @param string $verification_code Hash token
	 * @return bool Success status
	 */
	public static function verifyEmailReset($user_id, $verification_code)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		// check if user-provided username + verification code combination exists
		$sql = "SELECT UserID
                  FROM codestructionuser
                 WHERE UserID = :user_id
                       AND VerificationHash = :user_password_reset_hash
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
	 * Writes the new password to the database
	 *
	 * @param string $user_name username
	 * @param string $user_password_hash
	 * @param string $user_password_reset_hash
	 *
	 * @return bool
	 */
	public static function saveNewUserEmail($user_id, $user_email, $user_password_reset_hash)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "UPDATE codestructionuser
                   SET Email = :user_email,
                       VerificationHash = NULL,
                       PasswordUpdated = 1,
                       Verified = 1
                 WHERE UserID = :user_id
                       AND VerificationHash = :user_password_reset_hash
                 LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(
			':user_email' => $user_email, ':user_id' => $user_id,
			':user_password_reset_hash' => $user_password_reset_hash
		));

		// if successful
		if ($query->rowCount() == 1) {
			return true;
		}
		return false;
	}

}
