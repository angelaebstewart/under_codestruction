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
     * 
     * Name: viewAssessment
     * Description:
     * When you click on an assessment link, it goes to the assessment for that lesson.
     * @author Ryan Lewis
     * @Date 3/11/2015
     */
    public function viewAssessment() {
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');
        $lessonID = Request::get('id');
        
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
    }

    /**
     * Name: createClass_action
     * Description:
     * When a student completes an assessment, also should handle the case
     * of if a teacher completes an assessment.
     * @author Ryan Lewis
     * @Date ?
     */
    public function submitAssessment() {
        
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
        if (AssessmentModel::didPassAssessment(Request::get('id'), $answers)) {
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
