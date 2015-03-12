<?php
/**
 * Description of AssessmentModel
 *
 */
class AssessmentModel {
    public static function canViewAssessment($lessonID) {
        //TO DO: also needs to take into consideration whether or not
        //the student has viewed the video and played the game
        
        return LessonModel::canViewLesson($lessonID);
    }
    
    
    public static function didPassAssessment($lessonID, $question1) {
        if ($lessonID == 1) {
            if ($question1 == 'answer3') {
                return true;
            }
        }
        
        return false;
    }
    
    public static function recordPassedAssessment($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE codestructionmoduleprogress 
                SET AssessmentStatus='Completed', CompletionAttemptNumber=CompletionAttemptNumber+1
                WHERE UserID = :user_id AND ModuleID = :lesson_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));
        
        return $query;
    }
    
    
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
