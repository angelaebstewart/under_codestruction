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
    
    public function canViewLesson($lessonID) {
        
        // TO DO: validate that the student has access to this lesson
        
        // For now, we'll simulate it by pretending that the student only has
        // access to the lesson with ID = 1
        
        if ($lessonID == '1') {
            return true;
        } else {
            return false;
        }
    }
    
    public function canViewGame($lessonID) {
        return LessonModel::canViewLesson($lessonID);
    }
    
    public function canViewAssessment($lessonID) {
        //TO DO: also needs to take into consideration whether or not
        //the student has viewed the video and played the game
        
        return LessonModel::canViewLesson($lessonID);
    }
    
    
    public function didPassAssessment($lessonID, $question1) {
        if ($lessonID == 1) {
            if ($question1 == 'answer3') {
                return true;
            }
        }
        
        return false;
    }
    
}
