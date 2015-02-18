<?php

/**
 * Description of AssessmentController
 * The AssessmentController Should Direct a teacher or student to the
 * specified assessment
 * Any action regarding an assessment should be routed to here.
 *
 * @author WalterC
 */
class AssessmentController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * When a student completes an assessment, also should handle the case
     * of if a teacher completes an assessment.
     */
    public function submitAssessment()
    {
        if (LessonModel::didPassAssessment(Request::get('id'), Request::post('question1'))) {
            Session::add('feedback_positive', 'Your passed the assessment!<br>(TO DO: store this in database)');
            Redirect::to('lesson/index');
        } else {
            Session::add('feedback_negative', 'Your failed the assessment...');
            Redirect::to('lesson/viewLesson/?id=' . Request::get('id'));
        }
    }

    /**
     * When you click on an assessment link, it goes to the assessment for that lesson.
     */
    public function viewAssessment() {
        if (LessonModel::canViewGame(Request::get('id'))) {
            $this->View->render('lesson/viewAssessment');
        } else {
            Redirect::to('lesson/index');
        }
    }

}
