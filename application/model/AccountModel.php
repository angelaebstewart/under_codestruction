<?php
/**
 * Description of AccountModel
 *
 */
class AccountModel {
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
     * @param $user_email
     *
     * @return mixed
     */
    public static function getUserIdByEmail($user_email) {
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
    
    public static function deleteTeacherAccount($userID) {
        if (isset($userID)) {
        $classList = ClassModel::getClassList($userID);
        
            foreach ($classList as $class)
            {
                ClassModel::removeClassAndRecords($class->ClassID);
            }
            $success = AccountModel::markUserInactive($userID);
        return $success;
        
        } else {
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
    
    
}
