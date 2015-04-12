<?php
/**
 * Description of AssessmentModel
 *
 */
class AssessmentModel {
    public static function canViewAssessment($user_id, $user_role, $lesson_id) {
        if (LessonModel::canViewLesson($user_id, $user_role, $lesson_id)) {
            return AccountModel::isTeacher($user_role) || LessonModel::hasViewedVideoAndGame($user_id, $lesson_id);
        } else {
            return false;
        }
    }
    
    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     * @param type $lessonID
     * @param type $answers
     * @return boolean
     */
    public static function didPassAssessment($lessonID, $answers) {
        foreach ($answers as $answer) {
            if ($answer !== "right") return false;
        }
        return true;
    }
    
    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     * @param type $user_id
     * @param type $lesson_id
     * @return type
     */
    public static function recordPassedAssessment($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE codestructionmoduleprogress 
                SET AssessmentStatus='Completed', CompletionAttemptNumber=CompletionAttemptNumber+1
                WHERE UserID = :user_id AND ModuleID = :lesson_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));
        
        return $query;
    }
    
    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     * @param type $user_id
     * @param type $lesson_id
     * @return type
     */
    public static function recordFailedAssessment($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE codestructionmoduleprogress 
                SET AssessmentStatus='In Progress', CompletionAttemptNumber=CompletionAttemptNumber+1
                WHERE UserID = :user_id AND ModuleID = :lesson_id AND AssessmentStatus <> 'Completed'";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));
        return $query;
    }
}
