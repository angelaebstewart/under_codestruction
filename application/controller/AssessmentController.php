<?php

/**
 * Called when a user views or submits an assessment. Any action regarding an 
 * assessment should be routed to here.
 */
class AssessmentController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Name: viewAssessment
     * Description:
     * When you click on an assessment link, it goes to the assessment for that lesson.
     * @author Ryan Lewis (modified: Walter, added checkAuthentication)
     * @Date 3/11/2015
     */
    public function viewAssessment() {
        Auth::checkAuthentication();
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');
        $lessonID = Request::get('id');
        
        if (isset($userID) && isset($userRole) && isset($lessonID)) {
            if (LessonModel::canViewLesson($userID, $userRole, $lessonID)) {
                if (AssessmentModel::canViewAssessment($userID, $userRole, $lessonID)) {
                    LessonModel::recordViewedAssessment($userID, $lessonID);
                    $this->View->render('lesson/viewAssessment');
                } else {
                    Redirect::to('lesson/index');
                }
            } else {
                Redirect::to('lesson/index');
            }
        } else {
            Redirect::to("error/index");
        }
    }

    /**
     * Name: submitAssessment
     * Description:
     * Called when a user submits an assessment. If the user passed, it directs
     * them to the lesson select page with a message of success. If the user failed,
     * it directs them
     * @author Ryan Lewis (modified: Walter, added checkAuthentication)
     * @Date ? (modified Date: 4/13/2015)
     */
    public function submitAssessment() {
        Auth::checkAuthentication();
        // Collect assessment answers into '$answers'
        $x = 1;
        while (true) {
            $value = Request::post("Q" . $x);
            if ($value === NULL) break;
            else {
                $answers["Q" . $x] = $value;
                $x++;
            }
        }
        
        $userID = Session::get('user_id');
        
        if (isset($userID)) {
            if (AssessmentModel::didPassAssessment(Request::get('id'), $answers)) {
                AssessmentModel::recordPassedAssessment($userID, Request::get('id'));

                Session::add('feedback_positive', Text::get('FEEDBACK_ASSESSMENT_PASSED'));
                Redirect::to('lesson/index');
            } else {
                Session::add('feedback_negative', Text::get('FEEDBACK_ASSESSMENT_FAILED'));
                Redirect::to('lesson/viewLesson/?id=' . Request::get('id'));
            }
        } else {
            Redirect::to('error/index');
        }
    }
}
