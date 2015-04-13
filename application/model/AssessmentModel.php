<?php
/**
 * Called when a user views a lesson's assessment.
 */
class AssessmentModel {
    
    /**
     * For a given user, user role, and lesson, determine whether or not the
     * user has access to that lesson's assessment.
     * 
     *
     * @param $user_id int The user's UserID
     * @param $user_role int The user's role (student=1, teacher=2)
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return bool True if the user does have access to the assessment;
     * false otherwise, or if the $user_id or $lesson_id are invalid
     */
    public static function canViewAssessment($user_id, $user_role, $lesson_id) {
        if (LessonModel::canViewLesson($user_id, $user_role, $lesson_id)) {
            return AccountModel::isTeacher($user_role) || LessonModel::hasViewedVideoAndGame($user_id, $lesson_id);
        } else {
            return false;
        }
    }
    
    /**
     * Given an array of assessment responses, determine whether or not all the
     * answers are correct (if all the answers are correct, the user passed the
     * assessment)
     * 
     * (Note: If the user views the source of the assessment, it is extremely obvious 
     * which answers are correct and which are not. This could be improved by
     * having some kind of obscure code that contains whether or not an answer
     * is correct, such as a random string of numbers with correct answers ending in
     * '3')
     *
     * @param $answers array Array of strings that represent the correctness
     * of answers selected from the assessment.
     * 
     * @return bool True if all answers are correct, false otherwise
     */
    public static function didPassAssessment($lessonID, $answers) {
        foreach ($answers as $answer) {
            if ($answer !== "right") return false;
        }
        return true;
    }
    
    /**
     * Record in the database that a user has completed the assessment for a lesson,
     * and increment the completion attempt number (only if it is the first time
     * this user has completed it)
     *
     * @param $user_id int The user's UserID
     * @param $lesson_id int The ModuleID of the lesson
     * 
     * @return int "1" if this is the first time this user has completed this 
     * assessment, "0" otherwise
     */
    public static function recordPassedAssessment($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE codestructionmoduleprogress 
                SET AssessmentStatus='Completed', CompletionAttemptNumber=CompletionAttemptNumber+1
                WHERE UserID = :user_id AND ModuleID = :lesson_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));
        
        return $query->rowCount();
    }
    
    /**
     * Record in the database that a user has failed the assessment for a lesson,
     * and increment the completion attempt number (Note: no change will take
     * place if the user has already passed it before)
     *
     * @param $user_id int The user's UserID
     * @param $lesson_id int The ModuleID of the lesson
     * 
     * @return int "1" if the user failed a lesson that has not previously
     * been passed, "0" otherwise
     */
    public static function recordFailedAssessment($user_id, $lesson_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE codestructionmoduleprogress 
                SET AssessmentStatus='In Progress', CompletionAttemptNumber=CompletionAttemptNumber+1
                WHERE UserID = :user_id AND ModuleID = :lesson_id AND AssessmentStatus <> 'Completed'";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id, ':lesson_id' => $lesson_id));
        
        return $query->rowCount();
    }
}
