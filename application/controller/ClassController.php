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
        $this->View->render('class/edit', null);
    }
    
    public function newClass() {
        
    }
    
    public function deleteClass($classID) {
        
    }
    
    public function viewClass($classID=''){
        $this->View->render('class/viewClass');
        
    }
}
