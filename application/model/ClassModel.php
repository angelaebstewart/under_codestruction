<?php

/**
 * Description of ClassModel
 * Handles the business logic for anything class related.
 */
class ClassModel {
    /*
     * Name: isClassTaughtByTeacher
     * Description:
     * Checks to see if the class that was specified is taught by the teacher
     * that was specified.
     * @author Walter Conway
     * @Date 2/21/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param string $className Class Name
     * @param int $teacherID The teacher's userID
     * @return boolean True if the class is taught by the teacher and false if it is not taught by the teacher.
     */
    public static function isClassTaughtByTeacher($classID, $teacherID) {
        if (isset($classID) && isset($teacherID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT ClassName FROM codestructionclass C WHERE C.TeacherID = '$teacherID' AND C.ClassID = '$classID' LIMIT 1";
            $arrayVariable = array(':teacher_ID' => $teacherID, ':class_ID' => $classID);
            $query = $db->prepare($sql);
            $query->execute($arrayVariable);
            if ($query->rowCount() == 0) {
                return false;
            }
            return true;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: getClassName
     * Description:
     * Retrieves the class name from database
     * @author Walter Conway
     * @Date 3/4/2015
     * @param $classID Class id
     * @param $teacherID Teacher id
     * @return The class Name or null, if empty set.
     */
    public static function getClassName($classID, $teacherID) {
        if (isset($classID) && isset($teacherID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT ClassName FROM codestructionclass C WHERE C.TeacherID = '$teacherID' AND C.ClassID = '$classID'";
            $arrayVariable = array(':teacher_ID' => $teacherID, ':class_ID' => $classID);
            $query = $db->prepare($sql);
            $query->execute($arrayVariable);
            return $query->fetch();
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: getClassList
     * Description:
     * Obtains a list of classes that the teacher specified teaches.
     * @author Walter Conway
     * @Date 2/21/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int $teacherID The teacher's userID
     * @return array of the the sql query: 
     * SELECT ClassID, ClassName FROM codestructionclass C WHERE C.TeacherID = teacherid;
     */

    public static function getClassList($teacherID) {
        if (isset($teacherID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT ClassID, ClassName FROM codestructionclass C WHERE C.TeacherID = '$teacherID' AND C.isValid = 1";
            $query = $db->prepare($sql);
            $arrayVariable = array(':teacher_ID' => $teacherID);
            $query->execute($arrayVariable);
            $allClasses = $query->fetchAll();
            return $allClasses;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /**
     * Name: getStudentsFromClass
     * Description:
     * Obtains a list of student's first name and last name and user ids from the specified class from a class
     * @author Walter Conway
     * @Date 2/21/2015
     * @param type $classID class id
     * @return type
     * @throws InvalidArgumentException
     */
    public static function getStudentsFromClass($classID) {
        if (isset($classID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT U.FirstName as fname, U.LastName as lname,U.UserID as uid 
                FROM codestructionuser U, codestructionenrollment E 
                WHERE U.UserID = E.UserID AND E.ClassID = :classID AND U.IsValid = 1 AND E.IsValid = 1";
            $query = $db->prepare($sql);
            $arrayVariable = array(':classID' => $classID);
            $query->execute($arrayVariable);
            $studentList = $query->fetchAll();
            return $studentList;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: getAllStudentsInClassProgress
     * Description:
     * Obtains a list of all the students in specified class progress
     * @author Walter Conway
     * @Date 2/21/2015
     * @param $classID
     * @return list of all the students in class progress
     */

    public static function getAllStudentsInClassProgress($classID) {

        $returnResult = array();
        $allStudentsInClass = self::getStudentsFromClass($classID);
        $studentName = "";
        $studentID = "";
        $allStudentsInClassProgress = array();
        foreach ($allStudentsInClass as $key => $value) {
            $studentName = $value->fname . " " . $value->lname;
            $studentID = $value->uid;
            array_push($allStudentsInClassProgress, array(
                'studentName' => $studentName,
                'userID' => $studentID,
                'studentProgress' => self::getStudentProgressInAllModulesInClass($studentID, $classID)
            ));
        }

        $allLessons = LessonModel::getAllLessons();
        $returnResult["lessons"] = $allLessons;
        $returnResult["progress"] = $allStudentsInClassProgress;
        return $returnResult;
    }

    /*
     * Name: getStudentProgressInAllModulesInClass
     * Description:
     * Obtains a list of student's progress in a certain class
     * @author Walter Conway
     * @Date 2/21/2015
     * @param $userID
     * @param $classID
     * @return list of the student's progress in class.
     */

    public static function getStudentProgressInAllModulesInClass($userID, $classID) {
        if (isset($userID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT cmp.AssessmentStatus, m.ModuleName, cmp.CompletionAttemptNumber "
                    . "FROM codestructionmoduleprogress as cmp,"
                    . " codestructionenrollment as e, codestructionmodule as m"
                    . " WHERE cmp.userID = :userID AND "
                    . " cmp.userID = e.userID AND "
                    . "m.ModuleID = cmp.ModuleID AND "
                    . "e.classID = :classID";
            $query = $db->prepare($sql);
            $arrayVariable = array(':classID' => $classID, ':userID' => $userID);
            $query->execute($arrayVariable);
            $allProgressFromClass = $query->fetchAll();
            return $allProgressFromClass;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: enrollStudentInClass
     * Description:
     * Enrolls a given user in a given class
     * @author Ethan Mata
     * @Date 2/27/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int studentID The students's userID
     * @param int $classID The class' classID
     * @return array of the the sql query: 
     *   INSERT INTO codestructionenrollment (UserID, ClassID, IsValid) VALUES (:userID, :classID, 1)
     */
    public static function enrollStudentInClass($studentID, $classID) {
        if (isset($studentID) && isset($classID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "INSERT INTO codestructionenrollment (UserID, ClassID, IsValid)
                    VALUES (:userID, :classID, 1)";
            $query = $db->prepare($sql);
            $arrayVariable = array(':userID' => $studentID, ':classID' => $classID);
            $query->execute($arrayVariable);
            $studentList = $query->fetchAll();
            return $studentList;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: removeStudentFromClass
     * Description:
     * Removes a given user from a given class if they are enrolled
     * @author Ethan Mata
     * @Date 2/27/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int studentID The students's userID
     * @param int $classID The class' classID
     * @return Boolean, true if the student was removed, false otherwise
     */
    public static function removeStudentFromClass($studentID, $classID) {
        if (isset($studentID) && isset($classID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "UPDATE codestructionenrollment SET IsValid=0 WHERE UserID = :userID AND ClassID = :classID AND IsValid = 1 LIMIT 1";
            $query = $db->prepare($sql);
            $arrayVariable = array(':userID' => $studentID, ':classID' => $classID);
            $query->execute($arrayVariable);
            if ($query->rowCount() == 1) {
                return True; // Removal succeeded
            }
            return False;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: createClassWithTitleAndTeacher
     * Description:
     * Creates a class with the given name and associated teacher
     * @author Ethan Mata
     * @Date 2/23/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int $teacherID The teacher's userID
     * @param int $classTitle The class' name
     * @return The new class entry
     */
    public static function createClassWithTitleAndTeacher($classTitle, $teacherID) {
        if (isset($teacherID) && isset($classTitle) && $classTitle != "") {
            $db = DatabaseFactory::getFactory()->getConnection();

            // Obtain the next class ID to be used
            $classID = ClassModel::getNextClassID();

            // Prevent duplicate class names
            if (ClassModel::doesValidClassExistWithName($classTitle)) {
                Session::add('feedback_negative', Text::get('FEEDBACK_CLASS_CREATE_FAILED_NAME'));
                return false;
            }
            // Create the new class record
            $class_sql = "INSERT INTO codestructionclass (ClassID, TeacherID, ClassName, IsValid) VALUES (:classID, :teacherID, :className, 1)";
            $class_query = $db->prepare($class_sql);
            $arrayVariable = array(':classID' => $classID, ':teacherID' => $teacherID, ':className' => $classTitle);
            $class_query->execute($arrayVariable);
            $newClassEntry = $class_query->fetch();

            return $newClassEntry;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: getNextClassID
     * Description:
     * Returns the next available ClassID
     * @author Ethan Mata
     * @Date 3/8/2015
     * @return The next classID
     */
    public static function getNextClassID() {
        $db = DatabaseFactory::getFactory()->getConnection();
        $id_sql = "SELECT MAX(Class.ClassID) as max_id FROM codestructionclass Class";
        $id_query = $db->prepare($id_sql);
        $id_query->execute();
        $id_result = $id_query->fetchAll();

        if ($id_result[0]->max_id == NULL) {
            $classID = 1;
        } else {
            $classID = $id_result[0]->max_id + 1;
        }
        return $classID;
    }

    /*
     * Name: doesClassExistWithName
     * Description:
     * Returns true if a class exists with that name, false otherwise
     * @author Ethan Mata
     * @Date 3/8/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param String $classTitle The class' name
     * @return Boolean, if the class exists
     */
    public static function doesValidClassExistWithName($className) {
        if (isset($className)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT COUNT(*) as result FROM codestructionclass Class WHERE ClassName = :className AND IsValid = 1";
            $query = $db->prepare($sql);
            $query->execute(array(':className' => $className));
            $result = $query->fetchAll();

            if ($result[0]->result == 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: doesClassExistWithID
     * Description:
     * Returns true if a class exists with that name, false otherwise
     * @author Ethan Mata
     * @Date 3/9/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int $classID The class' id number
     * @return Boolean, if the class exists
     */
    public static function doesClassExistWithID($classID) {
        if (isset($classID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "SELECT COUNT(*) as result FROM codestructionclass Class WHERE ClassID = :classID";
            $query = $db->prepare($sql);
            $query->execute(array(':classID' => $classID));
            $result = $query->fetchAll();

            if ($result[0]->result == 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: markClassInactive
     * Description:
     * Marks a class as inactive
     * @author Ethan Mata
     * @Date 3/8/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int $classID The classID to change
     * @return Boolean, whether a class was marked as inactive
     */
    public static function markClassInactive($classID) {
        if (isset($classID)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            $sql = "UPDATE codestructionclass SET IsValid=0 WHERE ClassID = :classID AND IsValid = 1 LIMIT 1";
            $query = $db->prepare($sql);
            $arrayVariable = array(':classID' => $classID);
            $query->execute($arrayVariable);
            if ($query->rowCount() == 1) {
                return True; // lpdate succeeded
            }
            return False;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /*
     * Name: removeClassAndRecords
     * Description:
     * Marks a class as inactive, and cleans up all related records.
     * @author Ethan Mata
     * @Date 3/15/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int $classID The classID to remove
     * @return Boolean, whether the class and all related information was deleted
     */
    public function removeClassAndRecords($classID) {

        if (isset($classID)) {
            $studentList = ClassModel::getStudentsFromClass($classID);
            foreach ($studentList as $value) {
                ClassModel::removeStudentFromClass($value->uid, $classID);
                AccountModel::markUserInactive($value->uid);
            }
            $class_success = ClassModel::markClassInactive($classID);
            return $class_success;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }
    /*
     * 
     */
    public function checkPin($userPin){
        
        $pinHash = new PasswordHash(Config::get("HASH_COST_LOG2", 'gen'), Config::get("HASH_PORTALBE", 'gen'));
        
        if (empty($userPin)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_OR_PASSWORD_FIELD_EMPTY'));
            return false;
        }
        
        $result = AccountModel::getUserDataByEmail(Session::get('user_email'));
        if (!$result) {
            Session::add('feedback_negative', Text::get('FEEDBACK_LOGIN_FAILED'));
            return false;
        }
        
        if (!$pinHash->CheckPassword($userPin, $result->Pin)) {
            // we say "password wrong" here, but less details like "login failed" would be better (= less information)
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_WRONG'));

            return false;
        }
        return true;
    }

}
