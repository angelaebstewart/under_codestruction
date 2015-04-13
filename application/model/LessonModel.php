<?php

/**
 * Called when the user views the lesson list or a lesson page.
 */
class LessonModel {

    /**
     * Get a list of all lessons in the system, with an indication of which
     * are currently accessible to the user.
     * 
     * @author Ryan Lewis
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
                        "id" => $lesson->ModuleID,
                        "ModuleDescription" => $lesson->ModuleDescription,
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
     * @author Ryan Lewis
     * 
     * @return array List of all ModuleIDs and ModuleNames in the system
     */
    public static function getAllLessons() {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT ModuleID, ModuleName, ModuleDescription FROM codestructionmodule";
        $query = $database->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Get the Descritpion of the lesson specified.
     * 
     * @author Ryan Lewis
     * 
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return List of module description strings associated with this lesson id
     * (should just be one)
     */
    public static function getLessonDescription($lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT  ModuleDescription
                    FROM codestructionmodule
                    WHERE ModuleID = :lesson_id";
        $query = $database->prepare($sql);
        $query->execute(array(':lesson_id' => $lesson_id));
        return $query->fetchAll();
    }

    /**
     * For any given lesson, return its ModuleName, GameLink, AssessmentLink,
     * and VideoLink.
     * 
     * @author Ryan Lewis
     * 
     * @param $user_id int The user's UserID
     * @param $user_role int The user's role (student=1, teacher=2)
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return array containing the ModuleName, GameLink, AssessmentLink, and
     * VideoLink of the lesson; if the lesson_id does not correspond to a
     * lesson in the system, the lessonData key value will be set to NULL
     */
    public static function getLessonData($user_id, $user_role, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT ModuleName, GameLink, AssessmentLink, VideoLink 
                    FROM codestructionmodule
                    WHERE ModuleID = :lesson_id";
        $query = $database->prepare($sql);
        $query->execute(array(':lesson_id' => $lesson_id));

        if ($query->rowCount() === 1) { // Data successfully pulled
            $lessonData = $query->fetch();
            $lessonData->canViewAssessment = AccountModel::isTeacher($user_role) || LessonModel::hasViewedVideoAndGame($user_id, $lesson_id);
            return array("lessonData" => $lessonData);
        } else { // Data not successfully pulled
            return array("lessonData" => NULL);
        }
    }

    /**
     * For any given user, get the ModuleID of the highest lesson he or she
     * has completed.
     * 
     * @author Ryan Lewis
     * 
     * @param $user_id int The user's UserID
     * 
     * @return int ModuleID of the highest lesson the user has completed; -1
     * if no lessons have been completed, or if the given user ID is invalid
     */
    public static function getHighestCompletedLesson($user_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
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
     * Get whether or not a user has started a particular lesson
     * 
     * @author Ryan Lewis
     * 
     * @param $user_id int The user's UserID
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return bool True if the user has started the lesson, false otherwise
     */
    public static function hasStartedLesson($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT 1 FROM codestructionmoduleprogress
            WHERE UserID = :user_id AND ModuleID = :lesson_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));

        return ($query->rowCount() >= 1);
    }

    /**
     * Get whether or not a user has viewed both the video and the game for
     * a particular lesson.
     * 
     * @author Ryan Lewis
     * 
     * @param $user_id int The user's UserID
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return bool True if the user has viewed both the video and the game
     * for the lesson, false otherwise
     */
    public static function hasViewedVideoAndGame($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT 1 FROM codestructionmoduleprogress
            WHERE UserID = :user_id AND ModuleID = :lesson_id
            AND VideoStatus='Completed' AND GameStatus='Completed'";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));

        return ($query->rowCount() >= 1);
    }
    
    /**
     * Record in the database that a user has started a particular lesson.
     * 
     * @author Ryan Lewis
     * 
     * @param $user_id int The user's UserID
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return int "1" if the user had not already started the lesson and the
     * data was successfully stored, "-1" otherwise
     */
    public static function recordStartedLesson($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "INSERT INTO codestructionmoduleprogress (UserID, ModuleID, GameStatus, VideoStatus, AssessmentStatus, CompletionAttemptNumber, isValid)
                VALUES (:user_id, :lesson_id, 'Not Started', 'Not Started', 'Not Started', 0, 1)";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));

        if ($query->rowCount() >= 1) {
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Record in the database that a user has viewed a particular lesson's video.
     * 
     * @author Ryan Lewis
     * 
     * @param $user_id int The user's UserID
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return int "1" if the user had not already viewed the video and the 
     * data was successfully stored, "-1" otherwise
     */
    public static function recordViewedVideo($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE codestructionmoduleprogress 
                SET VideoStatus='Completed'
                WHERE UserID = :user_id AND ModuleID = :lesson_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));

        if ($query->rowCount() >= 1) {
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Record in the database that a user has viewed a particular lesson's game.
     * 
     * @author Ryan Lewis
     * 
     * @param $user_id int The user's UserID
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return int "1" if the user had not already viewed the game and the 
     * data was successfully stored, "-1" otherwise
     */
    public static function recordViewedGame($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE codestructionmoduleprogress 
                SET GameStatus='Completed'
                WHERE UserID = :user_id AND ModuleID = :lesson_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));

        if ($query->rowCount() >= 1) {
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Record in the database that a user has viewed a particular lesson's
     * assessment.
     * 
     * @author Ryan Lewis
     * 
     * @param $user_id int The user's UserID
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return int "1" if the user had not already viewed the assessment and the 
     * data was successfully stored, "-1" otherwise
     */
    public static function recordViewedAssessment($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE codestructionmoduleprogress 
                SET AssessmentStatus='In Progress'
                WHERE UserID = :user_id AND ModuleID = :lesson_id AND AssessmentStatus<>'Completed'";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));

        if ($query->rowCount() >= 1) {
            return 1;
        } else {
            return -1;
        }
    }

    /**
     * Determine whether a given lesson ID corresponds to an actual lesson in
     * the system.
     * 
     * @author Ryan Lewis
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
     * @author Ryan Lewis
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
