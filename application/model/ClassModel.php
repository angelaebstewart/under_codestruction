<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassModel
 *
 * @author WalterC
 */
class ClassModel {
    
/*
 * Check if this class is accessable by the teacher
 * This should stop another teacher from looking at 
 * another teacher's students.
 */
    public static function canViewClass($classID, $teacherID) {
        
        if($classID == 1 && $teacherID == 1){
            return true;
        }
        return false;
    }
    
    
}
