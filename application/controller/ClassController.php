<?php
/**
 * Description of ClassController
 *
 * @author WalterC
 */
class ClassController extends Controller{
     /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method controls what happens when you move to /class/index in your app.
     * Gets all classes (of the user).
     */
    public function index()
    {        
        $this->View->render('class/index');
    }
    
    public function edit($classID) {
        $this->View->render('class/editClass', null);
    }
    
    public function createClass() {
        
        $this->View->render('class/createClass', null);
    }
    
    public function createClass_action(){        
        //Auth::checkAuthentication();
        $result = ClassModel::canStudentBeAddedToClass(Request::post('classTitle'),Request::post('uid'));
        $this->View->render('class/createClass', $result);
    }
    
    public function deleteClass($classID) {
        
    }
    
    public function viewClass(){
        if(ClassModel::canViewClass(Request::get('classID'), Request::get('teacherID'))){            
            $this->View->render('class/viewClass');
        } else{
            Redirect::to("class/index");
        }
        
    }
}
