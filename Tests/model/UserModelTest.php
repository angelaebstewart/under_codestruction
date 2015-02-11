<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserModelTest
 *
 * @author WalterC
 */
class UserModelTest extends PHPUnit_Framework_TestCase{
    
    public function testDoesEmailAlreadyExisit_Success(){
        $db = DatabaseFactory::getFactory();
        $dbConn = $db->getConnection();
        $test_email = "teacher@admin.com";
        $result = UserModel::doesEmailAlreadyExist($test_email);
        
        $this->assertEquals($result, true);
        
    }
    
        public function testDoesEmailAlreadyExisit_Failure(){            
        $test_email = "failure@failure.com";
        $result = UserModel::doesEmailAlreadyExist($test_email);        
        $this->assertEquals($result, false);
        }
        
        public function testIsUserATeacher_Success(){
            
            $result = UserModel::isTeacher($role);
            $this->assertEquals($result, true);
        }
        
        public function testIsUserATeacher_Failure(){            
            $result = UserModel::isTeacher($role);
        }
        
        public function testIsUserAStudent_Success(){
            
            
        }
        
        public function testIsUserAStudent_Failure(){
            
        }
}
