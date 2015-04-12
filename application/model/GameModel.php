<?php

/**
 * Description of GameModel
 *
 */
class GameModel {

    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     * @param type $userID
     * @param type $userRole
     * @param type $lessonID
     * @return type
     */
    public static function canViewGame($userID, $userRole, $lessonID) {
        return LessonModel::canViewLesson($userID, $userRole, $lessonID);
    }

}
