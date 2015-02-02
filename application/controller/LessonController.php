<?php
/**
 * Description of LessonController
 *
 * @author WalterC
 */
class LessonController extends Controller{
    
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method controls what happens when you move to /lesson/index in your app.
     * Gets all lessons (of the user).
     */
    public function index()
    {
        $this->View->render('lesson/index');
    }
    
    
    /**
     * When you click on a lesson, it goes to the lesson's page.
     * Lists the video, game, and assessment for this lesson.
     */
    public function viewLesson()
    {
        if (LessonModel::canViewLesson(Request::get('id'))) {
            $this->View->render('lesson/viewLesson');
        } else {
            Redirect::to('lesson/index');
        }
    }
    
    /**
     * When you click on a game link, it goes to the game for that lesson.
     */
    public function viewGame()
    {
        if (LessonModel::canViewGame(Request::get('id'))) {
            $this->View->render('lesson/viewGame');
        } else {
            Redirect::to('lesson/index');
        }
    }
    
    /**
     * When you click on an assessment link, it goes to the assessment for that lesson.
     */
    public function viewAssessment()
    {
        if (LessonModel::canViewGame(Request::get('id'))) {
            $this->View->render('lesson/viewAssessment');
        } else {
            Redirect::to('lesson/index');
        }
    }
    
    /**
     * Called when an assessment is submitted
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
}
