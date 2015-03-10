<?php
/**
 * Description of AccountModel
 *
 */
class AccountModel {

    /**
     * Upgrades the user's account (for DEFAULT)
     * Currently it's just the field user_account_type in the database that
     * can be 1 or 2 (maybe "basic" or "premium"). In this basic method we
     * simply increase this value to emulate an account upgrade.
     * Put some more complex stuff in here, maybe a pay-process or whatever you like.
     */
    public static function changeAccountTypeUpgrade() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("UPDATE users SET user_account_type = 2 WHERE user_id = :user_id LIMIT 1");
        $query->execute(array(':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            // set account type in session to 2
            Session::set('user_account_type', 2);
            Session::add('feedback_positive', Text::get('FEEDBACK_ACCOUNT_UPGRADE_SUCCESSFUL'));
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_UPGRADE_FAILED'));
        return false;
    }

    /**
     * Downgrades the user's account (for DEFAULT)
     * Currently it's just the field user_account_type in the database that
     * can be 1 or 2 (maybe "basic" or "premium"). In this basic method we
     * simply decrease this value to emulate an account downgrade.
     * Put some more complex stuff in here, maybe a pay-process or whatever you like.
     */
    public static function changeAccountTypeDowngrade() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("UPDATE users SET user_account_type = 1 WHERE user_id = :user_id LIMIT 1");
        $query->execute(array(':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            // set account type in session to 1
            Session::set('user_account_type', 1);
            Session::add('feedback_positive', Text::get('FEEDBACK_ACCOUNT_DOWNGRADE_SUCCESSFUL'));
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_DOWNGRADE_FAILED'));
        return false;
    }

    /**
     * Checks if a username is already taken
     *
     * @param $user_name string username
     *
     * @return bool
     */
    public static function doesUsernameAlreadyExist($user_name) {
        return AccountModel::doesEmailAlreadyExist($user_name);
    }

    /**
     * Checks if a email is already used
     *
     * @param $user_email string email
     *
     * @return bool
     */
    public static function doesEmailAlreadyExist($user_email) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("SELECT UserID FROM codestructionuser WHERE Email = :user_email LIMIT 1");
        $query->execute(array(':user_email' => $user_email));
        if ($query->rowCount() == 0) {
            return false;
        }
        return true;
    }

    /**
     * Gets a user's profile data, according to the given $user_id
     * @param int $user_id The user's id
     * @return mixed The selected user's profile
     */
    public static function getPublicProfileOfUser($user_id) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT UserID, FirstName, LastName, Email, 
                        CAST(Type AS unsigned integer) AS Type, 
                        CAST(verified AS unsigned integer) AS verified
                FROM codestructionuser 
                WHERE UserID = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));

        $user = $query->fetch();

        if ($query->rowCount() != 1) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USER_DOES_NOT_EXIST'));
        }

        return $user;
    }

    /**
     * Gets the user's id
     *
     * @param $user_name
     *
     * @return mixed
     */
    public static function getUserIdByUsername($user_name) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT UserID FROM codestructionuser WHERE Email = :user_name LIMIT 1";
        $query = $database->prepare($sql);

        $query->execute(array(':user_name' => $user_name));

        $result = $query->fetch();

        if (!empty($result)) {
            return $result->UserID;
        } else {
            return -1;
        }
    }

    public static function getUserIdByEmail($user_email) {
        return AccountModel::getUserIdByUsername($user_email);
    }

    /**
     * Gets the user's data
     *
     * @param $user_name string User's name
     *
     * @return mixed Returns false if user does not exist, returns object with user's data when user exists
     */
    public static function getUserDataByUsername($user_name) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT  UserID, FirstName, LastName, Email,
                        CAST(Type AS unsigned integer) AS Type,
                        CAST(verified AS unsigned integer) AS verified, 
                        CAST(passwordUpdated AS unsigned integer) AS passwordUpdated, 
                        passwordHash
                  FROM codestructionuser
                 WHERE Email = :user_name
                 LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_name' => $user_name));

        // return one row (we only have one result or nothing)
        return $query->fetch();
    }

    /**
     * @param $user_name_or_email
     *
     * @return mixed
     */
    public static function getUserDataByUserNameOrEmail($user_name_or_email) {
        return AccountModel::getUserDataByUsername($user_name_or_email);
    }

    public static function isTeacher($role) {
        return ($role == Config::get('ROLE_TEACHER', 'gen'));
    }

    public static function isStudent($role) {
        return ($role == Config::get('ROLE_STUDENT', 'gen'));
    }

    /*
     * Name: markUserInactive
     * Description:
     *  Marks a user as inactive
     * @author Ethan Mata
     * @Date 3/8/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int $userID The userID to change
     * @return Boolean, whether a user was marked as inactive
     */
    public static function markUserInactive($userID) {
        if (isset($userID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "UPDATE codestructionuser SET IsValid=0 WHERE UserID = :userID AND IsValid = 1 LIMIT 1";
            $query = $db->prepare($sql);
            $arrayVariable = array(':userID' => $userID);
            $query->execute($arrayVariable);
            if ($query->rowCount() == 1) {
                return True; // Update succeeded
            }
            return False;
        }
        else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }
    
    
    
    /*
     * Name: createLoginRecord
     * Description:
     *  Creates a record of the user's failed login attempts
     * @author Ethan Mata
     * @Date 3/9/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int $userID The userID to create the record for
     * @return Boolean, whether a row was successfully created
     */
    public static function createLoginRecord($userID) {
        if (isset($userID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "INSERT INTO codestructionloginattempt (UserID, AttemptNumber) VALUES(:userID, 0)";
            $query = $db->prepare($sql);
            $arrayVariable = array(':userID' => $userID);
            $query->execute($arrayVariable);
            if ($query->rowCount() == 1) {
                return True; 
            }
            return False;
        }
        else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }
    /**
     * Edit the user's name, provided in the editing form
     *
     * @param $new_user_name string The new username
     *
     * @return bool success status
     */
    /*
      public static function editUserName($new_user_name)
      {
      // new username provided ?
      if (empty($new_user_name)) {
      Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_FIELD_EMPTY'));
      return false;
      }

      // new username same as old one ?
      if ($new_user_name == Session::get('user_name')) {
      Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_SAME_AS_OLD_ONE'));
      return false;
      }

      // username cannot be empty and must be azAZ09 and 2-64 characters
      if (!preg_match("/^[a-zA-Z0-9]{2,64}$/", $new_user_name)) {
      Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN'));
      return false;
      }

      // clean the input, strip usernames longer than 64 chars (maybe fix this ?)
      $new_user_name = substr(strip_tags($new_user_name), 0, 64);

      // check if new username already exists
      if (UserModel::doesUsernameAlreadyExist($new_user_name)) {
      Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_ALREADY_TAKEN'));
      return false;
      }

      $status_of_action = UserModel::saveNewUserName(Session::get('user_id'), $new_user_name);
      if ($status_of_action) {
      Session::set('user_name', $new_user_name);
      Session::add('feedback_positive', Text::get('FEEDBACK_USERNAME_CHANGE_SUCCESSFUL'));
      return true;
      }

      // default fallback
      Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
      return false;
      } */

    /**
     * Edit the user's email
     *
     * @param $new_user_email
     *
     * @return bool success status
     */
    /*
      public static function editUserEmail($new_user_email)
      {
      // email provided ?
      if (empty($new_user_email)) {
      Session::add('feedback_negative', Text::get('FEEDBACK_EMAIL_FIELD_EMPTY'));
      return false;
      }

      // check if new email is same like the old one
      if ($new_user_email == Session::get('user_email')) {
      Session::add('feedback_negative', Text::get('FEEDBACK_EMAIL_SAME_AS_OLD_ONE'));
      return false;
      }

      // user's email must be in valid email format, also checks the length
      // @see http://stackoverflow.com/questions/21631366/php-filter-validate-email-max-length
      // @see http://stackoverflow.com/questions/386294/what-is-the-maximum-length-of-a-valid-email-address
      if (!filter_var($new_user_email, FILTER_VALIDATE_EMAIL)) {
      Session::add('feedback_negative', Text::get('FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN'));
      return false;
      }

      // strip tags, just to be sure
      $new_user_email = substr(strip_tags($new_user_email), 0, 254);

      // check if user's email already exists
      if (UserModel::doesEmailAlreadyExist($new_user_email)) {
      Session::add('feedback_negative', Text::get('FEEDBACK_USER_EMAIL_ALREADY_TAKEN'));
      return false;
      }

      // write to database, if successful ...
      // ... then write new email to session, Gravatar too (as this relies to the user's email address)
      if (UserModel::saveNewEmailAddress(Session::get('user_id'), $new_user_email)) {
      Session::set('user_email', $new_user_email);
      Session::set('user_gravatar_image_url', AvatarModel::getGravatarLinkByEmail($new_user_email));
      Session::add('feedback_positive', Text::get('FEEDBACK_EMAIL_CHANGE_SUCCESSFUL'));
      return true;
      }

      Session::add('feedback_negative', Text::get('FEEDBACK_UNKNOWN_ERROR'));
      return false;
      } */

    /**
     * Writes new username to database
     *
     * @param $user_id int user id
     * @param $new_user_name string new username
     *
     * @return bool
     */
    /*
      public static function saveNewUserName($user_id, $new_user_name)
      {
      $database = DatabaseFactory::getFactory()->getConnection();

      $query = $database->prepare("UPDATE users SET user_name = :user_name WHERE user_id = :user_id LIMIT 1");
      $query->execute(array(':user_name' => $new_user_name, ':user_id' => $user_id));
      if ($query->rowCount() == 1) {
      return true;
      }
      return false;
      } */

    /**
     * Writes new email address to database
     *
     * @param $user_id int user id
     * @param $new_user_email string new email address
     *
     * @return bool
     */
    /*
      public static function saveNewEmailAddress($user_id, $new_user_email)
      {
      $database = DatabaseFactory::getFactory()->getConnection();

      $query = $database->prepare("UPDATE users SET user_email = :user_email WHERE user_id = :user_id LIMIT 1");
      $query->execute(array(':user_email' => $new_user_email, ':user_id' => $user_id));
      $count =  $query->rowCount();
      if ($count == 1) {
      return true;
      }
      return false;
      } */
}
