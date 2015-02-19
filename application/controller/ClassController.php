<?php
/**
 * Description of ClassController
 *
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
    
    public function edit($classID='') {
        $this->View->render('class/editClass', null);
    }
    
    public function createClass() {
        
        $this->View->render('class/createClass', null);
    }
    
    public function createClass_action(){        
        //Auth::checkAuthentication();
        $classTitle = Request::post('clsname');
        $resultText = ClassModel::canStudentBeAddedToClass($classTitle);
        $resultJSON = json_encode($resultText);
        $this->View->renderJSON($resultJSON);
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
    
    public function viewTest() {
        $this->View->render('class/test');
    }
}
