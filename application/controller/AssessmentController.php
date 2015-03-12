<?php

/**
 * Description of AssessmentController
 * The AssessmentController Should Direct a teacher or student to the
 * specified assessment
 * Any action regarding an assessment should be routed to here.
 *
 */
class AssessmentController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * When you click on an assessment link, it goes to the assessment for that lesson.
     */
    public function viewAssessment() {
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');
        if (GameModel::canViewGame($userID, $userRole, Request::get('id'))) {
            $this->View->render('lesson/viewAssessment');
        } else {
            Redirect::to('lesson/index');
        }
    }

    /*
     * When a student completes an assessment, also should handle the case
     * of if a teacher completes an assessment.
     */
    public function submitAssessment()
    {
        $userID = Session::get('user_id');
        if (AssessmentModel::didPassAssessment(Request::get('id'), Request::post('question1'))) {
            AssessmentModel::recordPassedAssessment($userID, Request::get('id'));
            
            Session::add('feedback_positive', 'You passed the assessment!');
            Redirect::to('lesson/index');
        } else {
            AssessmentModel::recordFailedAssessment($userID, Request::get('id'));
            
            Session::add('feedback_negative', 'You failed the assessment. Try again!');
            Redirect::to('lesson/viewLesson/?id=' . Request::get('id'));
        }
    }
}
