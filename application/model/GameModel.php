<?php

/**
 * Description of GameModel
 *
 */
class GameModel {
    
    /**
     * For a given user, user role, and lesson, determine whether or not the
     * user has access to that lesson's game.
     *
     * @param $user_id int The user's UserID
     * @param $user_role int The user's role (student=1, teacher=2)
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @return bool True if the user does have access to the game;
     * false otherwise, or if the $user_id or $lesson_id are invalid
     */
    public static function canViewGame($userID, $userRole, $lessonID) {
        return LessonModel::canViewLesson($userID, $userRole, $lessonID);
    }

}
