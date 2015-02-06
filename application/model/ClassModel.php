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
    
    public static function doesTeacherAlreadyTeachThisClass($className, $teacherID=2){
//        $db = DatabaseFactory::getFactory();        
//        $db.getConnection();
//        There needs to be a input sanitizer
//        $sql = "SELECT title FROM class C WHERE C.uid = $teacherID AND C.title = $className";
//        $query = $database->prepare($sql);
//        $query->execute();
        return true;
        
    }
    
    public static function canStudentBeAddedToClass($classID){
        return $classID . " is Alive and well and yes you can add it.";
    }
    
    public static function getStudentsFromClass($classID){
        
    }
    
    
}
