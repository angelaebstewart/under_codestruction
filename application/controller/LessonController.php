<?php

/**
 * Controller for viewing the lesson list or a lesson page.
 */
class LessonController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Called when you move to /lesson/index. Shows a list of lessons, with
     * links to lesson pages for the lessons that are currenlty available to
     * the user.
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
     * Displays a lesson page. Has links to the video, game, and 
     * assessment for the given lesson.
     */
    public function viewLesson() {
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');
        $lesson_id = Request::get('id');
        
        if (LessonModel::canViewLesson($userID, $userRole, $lesson_id)) {
            $lessonData = LessonModel::getLessonData($lesson_id);
            $this->View->render('lesson/viewLesson', $lessonData);
        } else {
            Redirect::to('lesson/index');
        }
    }

}
