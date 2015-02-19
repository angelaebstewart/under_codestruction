<?php
/**
 * Description of GameModel
 *
 */
class GameModel {    
    public static function canViewGame($lessonID) {
        return LessonModel::canViewLesson($lessonID);
    }
}
