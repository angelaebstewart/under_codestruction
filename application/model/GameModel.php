<?php

/**
 * Called when the user views a lesson's game.
 */
class GameModel {
    
    /**
     * For a given user, user role, and lesson, determine whether or not the
     * user has access to that lesson's game.
     * 
     * @author Ryan Lewis
     *
     * @param $user_id int The user's UserID
     * @param $user_role int The user's role (student=1, teacher=2)
     * @param $lesson_id int The ModuleID for the lesson in question
     * 
     * @throws InvalidArgumentException when parameters are not used.
     * 
     * @return bool True if the user does have access to the game;
     * false otherwise, or if the $user_id or $lesson_id are invalid
     */
    public static function canViewGame($userID, $userRole, $lessonID) {
        if (isset($userID) && isset($userRole) && isset($lessonID)) {
            return LessonModel::canViewLesson($userID, $userRole, $lessonID);
        } else {
            throw new InvalidArgumentException("Invalid Parameters");
        }
    }

}
