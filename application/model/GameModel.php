<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GameModel
 *
 * @author WalterC
 */
class GameModel {    
    public static function canViewGame($lessonID) {
        return LessonModel::canViewLesson($lessonID);
    }
}
