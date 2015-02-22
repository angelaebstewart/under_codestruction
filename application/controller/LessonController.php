<?php

/**
 * Description of LessonController
 *
 */
class LessonController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * This method controls what happens when you move to /lesson/index in your app.
     * Gets all lessons (of the user).
     */
    public function index() {
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');
        if(isset($userID) && isset($userRole)){
            $lessons = LessonModel::getLessonList($userID, $userRole);
            $this->View->render('lesson/index', $lessons);
        } else {
            Redirect::to("error/index");
        }
    }

    /**
     * When you click on a lesson, it goes to the lesson's page.
     * Lists the video, game, and assessment for this lesson.
     */
    public function viewLesson() {
        if (LessonModel::canViewLesson(Request::get('id'))) {
            $this->View->render('lesson/viewLesson');
        } else {
            Redirect::to('lesson/index');
        }
    }

}
