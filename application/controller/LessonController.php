<?php

/**
 * Called when a user views the lesson list or a lesson page.
 */
class LessonController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Name: index
     * Description:
     * Called when you move to /lesson/index. Shows a list of lessons, with
     * links to lesson pages for the lessons that are currenlty available to
     * the user.
     * @author Ryan Lewis
     */
    public function index() {
        Auth::checkAuthentication();
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
     * Name: viewLesson
     * Description:
     * Called when a user views a lesson page. Has links to the video, game, and 
     * assessment for the lesson.
     * @author Ryan Lewis
     */
    public function viewLesson() {
        Auth::checkAuthentication();
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');
        $lesson_id = Request::get('id');
        
        if(isset($userID) && isset($userRole) && isset($lesson_id)) {
            if (LessonModel::canViewLesson($userID, $userRole, $lesson_id)) {
                if (!LessonModel::hasStartedLesson($userID, $lesson_id)) {
                    LessonModel::recordStartedLesson($userID, $lesson_id);
                }
                $lessonData = LessonModel::getLessonData($userID, $userRole, $lesson_id);
                $this->View->render('lesson/viewLesson', $lessonData);
            } else {
                Redirect::to('lesson/index');
            }
        } else {
            Redirect::to('error/index');
        }
    }
    
    /**
     * Name: viewVideo_action
     * Description:
     * Called when a user clicks the video link on a lesson page. Records in the
     * database that the user has viewed the video, and returns the link to the
     * assessment page (for the case that the user has already viewed the game,
     * so that the assessment link can be shown without a page reload.)
     * @author Ryan Lewis
     */
    public function viewVideo_action() {
        Auth::checkAuthentication();
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');
        $lessonID = Request::post('lessonID');
        
        if(isset($userID) && isset($userRole) && isset($lessonID)) {
            if (LessonModel::canViewLesson($userID, $userRole, $lessonID)) {
                LessonModel::recordViewedVideo($userID, $lessonID);
                
                $response_array['canViewAssessment'] = LessonModel::hasViewedVideoAndGame($userID, $lessonID);
                echo json_encode($response_array);
            } else {
                Redirect::to('lesson/index');
            }
        } else {
            Redirect::to('error/index');
        }
    }

}
