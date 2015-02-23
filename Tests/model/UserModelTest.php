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
        $test_email = "wconway.j@gmail.com";
        $result = AccountModel::doesEmailAlreadyExist($test_email);
        
        $this->assertEquals($result, true);
        
    }
    
        public function testDoesEmailAlreadyExisit_Failure(){            
        $test_email = "failure@failure.com";
        $result = AccountModel::doesEmailAlreadyExist($test_email);        
        $this->assertEquals($result, false);
        }
        
        public function testIsUserATeacher_Success(){
            
        }
        
        public function testIsUserATeacher_Failure(){      
        }
        
        public function testIsUserAStudent_Success(){
            
            
        }
        
        public function testIsUserAStudent_Failure(){
            
        }
}
