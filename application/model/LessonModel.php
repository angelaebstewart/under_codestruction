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
        
        $database = DatabaseFactory::getFactory()->getConnection();

        // Eventually there be a way to pick the modules for a class?
        $sql = "SELECT ModuleID, ModuleName FROM codestructionmodule";
        $query = $database->prepare($sql);
        $query->execute();
        
        $lessonData = $query->fetchAll();
        $lessons = array("lessonList" => array());
        
        $isTeacher = AccountModel::isTeacher(Session::get('user_role'));
        $highestLesson = -1;
        if (!$isTeacher) {
            $highestLesson = LessonModel::getHighestCompletedLesson($user_id);

            if ($highestLesson == -1) { // No lessons have been started
                $highestLesson = 0;
            }
        }
        
        foreach ($lessonData as $key => $lesson) {
            if ($isTeacher || intval($lesson->ModuleID) <= $highestLesson+1) {
                array_push($lessons["lessonList"], array(
                    "name" => $lesson->ModuleName,
                    "id" => $lesson->ModuleID
                ));
            } else {
                array_push($lessons["lessonList"], array(
                    "name" => $lesson->ModuleName
                ));
            }
        }
        
        return $lessons;
    }
    
    public static function getHighestCompletedLesson($user_id) {
        $database = DatabaseFactory::getFactory()->getConnection();

        // Eventually there should be a way to pick the modules for a class?
        $sql = "SELECT ModuleID
            FROM codestructionmoduleprogress
            WHERE uid = :user_id AND AssessmentStatus='Completed'";
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
    
    public static function canViewLesson($lessonID) {
        
        // TO DO: validate that the student has access to this lesson
        
        // For now, we'll simulate it by pretending that the student only has
        // access to the lesson with ID = 1
        
        if ($lessonID == '1') {
            return true;
        } else {
            return false;
        }
    }    
}
