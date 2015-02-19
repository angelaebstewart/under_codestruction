<?php
/**
 * Description of LessonModel
 *
 */
class LessonModel {
    
    public static function getLessonList($user_id) {
        if (!$user_id) {
            $user_id = Session::get('user_id');
        }
        
        // Get all the lessons in the system
        $lessonData = LessonModel::getAllLessons();
        
        // If it's a teacher, all the lessons will be available.
        // If it's a student, we need to figure out which is the latest available to them
        $isTeacher = AccountModel::isTeacher(Session::get('user_role'));
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
            if ($isTeacher || intval($lesson->ModuleID) <= $highestLesson+1) {
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
    }
    
    public static function getAllLessons() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT ModuleID, ModuleName FROM codestructionmodule";
        $query = $database->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
    }
    
    public static function getHighestCompletedLesson($user_id) {
        $database = DatabaseFactory::getFactory()->getConnection();

        // Eventually there should be a way to pick the modules for a class?
        $sql = "SELECT ModuleID
            FROM codestructionmoduleprogress
            WHERE UserID = :user_id AND AssessmentStatus='Completed'";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));
        
        $lessonsCompleted = $query->fetchAll();
        
        $highestLesson = -1;
        foreach ($lessonsCompleted as $key => $lesson) {
            $lessonNum = intval($lesson->ModuleID);
            if ($lessonNum > $highestLesson) $highestLesson = $lessonNum;
        }
        
        return $highestLesson;
    }
    
    public static function canViewLesson($lesson_id) {
        
        // TO DO: validate that the student has access to this lesson
        
        // For now, we'll simulate it by pretending that the student only has
        // access to the lesson with ID = 1
        
        if ($lesson_id == '1') {
            return true;
        } else {
            return false;
        }
    }    
}
