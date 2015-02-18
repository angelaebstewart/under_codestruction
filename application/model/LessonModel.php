<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LessonModel
 *
 * @author WalterC
 */
class LessonModel {
    
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
