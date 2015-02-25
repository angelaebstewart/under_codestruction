<?php

/**
 * Description of ClassController
 *
 */
class ClassController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Name: index
     * Description:
     * Directs only the teacher to the class list and shows only the teacher's
     * classes. Everyone else will be redirected to the error page.
     * @author Walter Conway
     * @Date 2/21/2015
     */
    public function index() {
        $teacherID = Session::get('user_id');
        $isTeacher = AccountModel::isTeacher(Session::get('user_role'));
        if (isset($teacherID) && isset($isTeacher)) {
            if ($isTeacher) {
                $classList = ClassModel::getClassList($teacherID);
                if (isset($classList)) {
                    $this->View->render('class/index', $classList);
                } else {
                    Redirect::to("error/index");
                }
            } else {
                Redirect::to("error/index");
            }
        } else {
            Redirect::to("error/index");
        }
    }

    public function edit($classID = '') {
        $this->View->render('class/editClass', null);
    }

    public function createClass() {

        $this->View->render('class/createClass', null);
    }

    public function createClass_action() {
        $classTitle = Request::post('classTitle');
        $teacherID = Session::get('user_id');
        
        $isTeacher = AccountModel::isTeacher(Session::get('user_role'));
        if (isset($isTeacher) && $isTeacher) {
            $resultText = ClassModel::createClassWithTitleAndTeacher($classTitle, $teacherID);
            $resultJSON = json_encode($resultText);
            $this->View->renderJSON($resultJSON);
        }
    }

    public function deleteClass($classID) {
        
    }

    /*
     * Name: viewClass
     * Description:
     * Directs only the teacher to the class specified in their list and shows only the teacher
     * that has access to the class specified. Everyone else will be redirected to the error page.
     * @author Walter Conway
     * @Date 2/21/2015
     */
    public function viewClass() {
        $teacherID = Session::get('user_id');
        $isTeacher = AccountModel::isTeacher(Session::get('user_role'));
        $classID = Request::get('classID');
        if (isset($teacherID) && isset($isTeacher) && isset($classID)) {
            if ($isTeacher) {
                if (ClassModel::isClassTaughtByTeacher($classID, $teacherID)) {
                    $this->View->render('class/viewClass');
                } else {
                    Redirect::to("error/index");
                }
            } else {
                Redirect::to("error/index");
            }
        } else {
            Redirect::to("error/index");
        }
    }

    public function viewTest() {
        $this->View->render('class/test');
    }

}
