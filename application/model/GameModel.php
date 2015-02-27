<?php
/**
 * Description of GameModel
 *
 */
class GameModel {    
    public static function canViewGame($userID, $userRole, $lessonID) {
        return LessonModel::canViewLesson($userID, $userRole, $lessonID);
    }
}
