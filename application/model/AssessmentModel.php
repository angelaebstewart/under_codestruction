<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AssessmentModel
 *
 * @author WalterC
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
}
