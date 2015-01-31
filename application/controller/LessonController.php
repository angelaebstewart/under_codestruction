<?php
/**
 * Description of LessonController
 *
 * @author WalterC
 */
class LessonController {
    
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method controls what happens when you move to /lessons/index in your app.
     * Gets all lessons (of the user).
     */
    public function index()
    {
        $this->View->render('lesson/index');
    }
}
