<?php

/**
 * Description of ClassModel
 * Handles the business logic for anything class related.
 */
class ClassModel {
    /*
     * Name: isClassTaughtByTeacher
     * Description:
     *  Checks to see if the class that was specified is taught by the teacher
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
     * Name: getClassList
     * Description:
     *  Obtains a list of classes that the teacher specified teaches.
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
     * Name: enrollStudentInClass
     * Description:
     *  Enrolls a given user in a given class
     * @author Ethan Mata
     * @Date 2/27/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int studentID The students's userID
     * @param int $classID The class' classID
     * @return array of the the sql query: 
     *   INSERT INTO codestructionenrollment (UserID, ClassID, IsValid) VALUES (:userID, :classID, 1)
     */
    public static function enrollStudentInClass($studentID, $classID) {
        if (isset($studentID) && isset($classID))
        {
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
     *  Removes a given user from a given class if they are enrolled
     * @author Ethan Mata
     * @Date 2/27/2015
     * @throws InvalidArgumentException when parameters are not used.
     * @param int studentID The students's userID
     * @param int $classID The class' classID
     * @return Boolean, true if the student was removed, false otherwise
     */
    public static function removeStudentFromClass($studentID, $classID) {
        if (isset($studentID) && isset($classID))
        {
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
    
    
        
    public static function createClassWithTitleAndTeacher($classTitle, $teacherID) {
        if (isset($teacherID) && isset($classTitle)) {
            $db = DatabaseFactory::getFactory()->getConnection();
            
            // Obtain the next class ID to be used
            $id_sql = "SELECT MAX(Class.ClassID) as max_id FROM codestructionclass Class";
            $id_query = $db->prepare($id_sql);
            $id_query->execute();
            $id_result = $id_query->fetchAll();
            
            if ($id_result[0]->max_id == NULL) {
                $classID = 1;
            }
            else {
                $classID = $id_result[0]->max_id + 1;
            }
           
            // Create the new class record$db = DatabaseFactory::getFactory()->getConnection();
            $class_sql = "INSERT INTO codestructionclass (ClassID, TeacherID, ClassName, IsValid) VALUES (:classID, :teacherID, :className, 1)";
            $class_query = $db->prepare($class_sql);
            $arrayVariable = array(':classID' => $classID,':teacherID' => $teacherID,':className' => $classTitle);
            $class_query->execute($arrayVariable);
            $newClassEntry = $class_query->fetchAll();
            
            return $newClassEntry;
            
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }
          
}
