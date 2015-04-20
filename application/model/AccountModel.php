<?php

/**
 * Description of AccountModel
 *
 */
class AccountModel {

    /**
     * Name: doesEmailAlreadyExist
     * Description:
     * Checks if a email is already used by a valid account
     * @author FRAMEWORK(modified: )
     * @Date 4/11/2015
     * @param $user_email string email
     * @return bool
     * @throws InvalidArgumentException when parameters are not used.
     */
    public static function doesEmailAlreadyExist($user_email) {
        if (isset($user_email)) {
            $database = DatabaseFactory::getFactory()->getConnection();
            $query = $database->prepare("SELECT UserID FROM codestructionuser WHERE Email = :user_email AND IsValid = True LIMIT 1");
            $query->execute(array(':user_email' => $user_email));
            if ($query->rowCount() == 0) {
                return false;
            }
            return true;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /**
     * Name: getUserIdByEmail
     * Description:
     * Gets the user's id
     * @author FRAMEWORK
     * @Date ?
     * NOTE: If the return statement changes then change requestPasswordReset_action method
     * @param $user_email
     * @return mixed userID or otherwise -1
     * @throws InvalidArgumentException when parameters are not used.
     */
    public static function getUserIdByEmail($user_email) {
        if (isset($user_email)) {
            $database = DatabaseFactory::getFactory()->getConnection();

            $sql = "SELECT UserID FROM codestructionuser WHERE Email = :user_email LIMIT 1";
            $query = $database->prepare($sql);

            $query->execute(array(':user_email' => $user_email));

            $result = $query->fetch();

            if (!empty($result)) {
                return $result->UserID;
            } else {
                return -1;
            }
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /**
     * Name: getUserDataByEmail
     * Description:
     * Gets the user's data
     * @author FRAMEWORK (Modified by: Ryan Lewis)
     * @Date ?
     * @param $user_name string User's name
     * @return mixed Returns false if user does not exist, returns object with user's data when user exists
     * @throws InvalidArgumentException when parameters are not used.
     */
    public static function getUserDataByEmail($user_email) {
        if (isset($user_email)) {
            $database = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT  UserID, FirstName, LastName, Email,
                        CAST(Type AS unsigned integer) AS Type,
                        CAST(verified AS unsigned integer) AS verified, 
                        CAST(passwordUpdated AS unsigned integer) AS passwordUpdated, 
                        passwordHash
                  FROM codestructionuser
                 WHERE Email = :user_email
                 LIMIT 1";
            $query = $database->prepare($sql);
            $query->execute(array(':user_email' => $user_email));
            // return one row (we only have one result or nothing)
            return $query->fetch();
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /**
     * Name: getUserRoleByID
     * Description:
     * Get the role of the user
     * @author ?
     * @Date ?
     * @param type $user_ID
     * @return type
     * @throws InvalidArgumentException when parameters are not used.
     */
    public static function getUserRoleByID($user_ID) {
        if (isset($userID)) {
            $database = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT CAST(Type AS unsigned integer) AS Type FROM codestructionuser
                 WHERE UserID = :userID
                 LIMIT 1";
            $query = $database->prepare($sql);
            $query->execute(array(':userID' => $user_ID));
            $result = $query->fetch();
            $string = $result->Type;
            return $string;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /**
     * Name: isTeacher
     * Description:
     * returns specific integer to represent the user as a teacher
     * @author Ryan Lewis
     * @Date ?
     * @param type $role
     * @return true if the specific role is a teacher
     * @throws InvalidArgumentException when parameters are not used.
     */
    public static function isTeacher($role) {
        if (isset($role)) {
            return ($role == Config::get('ROLE_TEACHER', 'gen'));
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /**
     * Name: isStudent
     * Description:
     * returns specific integer to represent the user as a student
     * @author Ryan Lewis
     * @Date ?
     * @param type $role
     * @return type
     * @throws InvalidArgumentException when parameters are not used.
     */
    public static function isStudent($role) {
        if (isset($role)) {
            return ($role == Config::get('ROLE_STUDENT', 'gen'));
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: markUserInactive
     * Description:
     * Marks a user as inactive
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
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /**
     * Name: deleteTeacherAccount
     * Description:
     * Marks the specified userId as deleted, but doesn't delete the user.
     * @author Ethan Mata
     * @Date ?
     * @param type $userID
     * @return type
     * @throws InvalidArgumentException
     */
    public static function deleteTeacherAccount($userID) {
        if (isset($userID)) {
            $classList = ClassModel::getClassList($userID);

            foreach ($classList as $class) {
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
     * Creates a record of the user's failed login attempts
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
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

}
