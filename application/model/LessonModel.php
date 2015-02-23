<?php

/**
 * Called when the user views the lesson list or a lesson page.
 */
class LessonModel {

    /**
    * Get a list of all lessons in the system, with an indication of which
    * are currently accessible to the user.
    *
    * @param $user_id int The user's UserID
    * @param $user_role int The user's role (student=1, teacher=2)
    * 
    * @return array List of all lessons in the system. All module "name"s
    * are given, but module "id"s are only given for those accessible to the 
    * user
    */
    public static function getLessonList($user_id, $user_role) {
        if (isset($user_id)) {

            // Get all the lessons in the system
            $lessonData = LessonModel::getAllLessons();

            // If it's a teacher, all the lessons will be available.
            // If it's a student, we need to figure out which is the latest available to them
            $isTeacher = AccountModel::isTeacher($user_role);
            $highestLesson = -1;
            if (!$isTeacher) {
                $highestLesson = LessonModel::getHighestCompletedLesson($user_id);

                if ($highestLesson == -1) { // No lessons have been started
                    $highestLesson = 0;
                }
            }

            $processedLessons = array("lessonList" => array());

            // Go through each lesson, only associate an 'id' with it if
            // they're allowed to view it.
            foreach ($lessonData as $key => $lesson) {
                if ($isTeacher || intval($lesson->ModuleID) <= $highestLesson + 1) {
                    array_push($processedLessons["lessonList"], array(
                        "name" => $lesson->ModuleName,
                        "id" => $lesson->ModuleID
                    ));
                } else {
                    array_push($processedLessons["lessonList"], array(
                        "name" => $lesson->ModuleName
                    ));
                }
            }

            return $processedLessons;
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

    /**
     * Get a list of all lessons in the system.
     * 
     * @return array List of all ModuleIDs and ModuleNames in the system
     */
    public static function getAllLessons() {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT ModuleID, ModuleName FROM codestructionmodule";
        $query = $database->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * For any given user, get the ModuleID of the highest lesson he or she
     * has completed.
     *
     * @param $user_id int The user's UserID
     * 
     * @return int ModuleID of the highest lesson the user has completed; -1
     * if no lessons have been completed, or if the given user ID is erroneous
     */
    public static function getHighestCompletedLesson($user_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        // Eventually there should be a way to pick the modules for a class?
        $sql = "SELECT MAX(ModuleID) AS ModuleID
            FROM codestructionmoduleprogress
            WHERE UserID = :user_id AND AssessmentStatus='Completed'";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));
        $result = $query->fetch();
        $highestLesson = $result->ModuleID;
        if ($highestLesson != null) {
            return $highestLesson;
        } else {
            return -1;
        }
    }
    
    /**
     * Determine whether a given lesson ID corresponds to an actual lesson in
     * the system.
     *
     * @param $lesson_id int ModuleID of a lesson in the system
     * 
     * @return bool True if the given ID does correspond to a lesson in the
     * system, false otherwise
     */
    public static function isValidLessonID($lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        
        $sql = "SELECT ModuleID
            FROM codestructionmodule
            WHERE ModuleID = :lesson_id";
        $query = $database->prepare($sql);
        $query->execute(array(':lesson_id' => $lesson_id));
        
        return ($query->rowCount() >= 1);
    }

    /**
     * For a given user, user role, and lesson, determine whether or not the
     * user has access to that lesson.
     *
     * @param $user_id int The user's UserID
     * @param $user_role int The user's role (student=1, teacher=2)
     * 
     * @return bool True if the user does have access to the given lesson;
     * false otherwise, or if the $user_id or $lesson_id are invalid
     */
    public static function canViewLesson($user_id, $user_role, $lesson_id) {
        if (LessonModel::isValidLessonID($lesson_id)) {
            if (AccountModel::isTeacher($user_role)) {
                return true;
            } else {
                $highestCompleted = LessonModel::getHighestCompletedLesson($user_id);

                if ($highestCompleted === -1) { // No lessons have been started
                    $highestCompleted = 0;
                }

                if ($lesson_id <= $highestCompleted + 1) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

}
