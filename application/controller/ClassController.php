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
        Auth::checkAuthentication();
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

    /**
     * Name: edit
     * Description:
     * When edit button is clicked loads up the information to be edited.
     * @author Victoria Richardson
     * @Date ?
     */
    public function edit() {
        Auth::checkAuthentication();
        $classID = Request::get('classID');
        if (isset($classID)) {
            try {
                $studentList = ClassModel::getStudentsFromClass($classID);
            } catch (InvalidArgumentException $e) {
                Redirect::to("error/index");
                return;
            }
            $this->View->render('class/editClass', $studentList);
        } else {
            Redirect::to("error/index");
        }
    }

    /**
     * Name: createClass_action
     * Description:
     * When create class button is clicked this is called
     * @author ?(modified by: Walter Conway, isset() and checkAuth)
     * @Date ?
     */
    public function createClass_action() {
        Auth::checkAuthentication();
        $classTitle = Request::post('classTitle');
        $teacherID = Session::get('user_id');
        $isTeacher = AccountModel::isTeacher(Session::get('user_role'));
        if (isset($classTitle) && isset($teacherID) && isset($isTeacher) && preg_match("/[A-Za-z\d\s]+/", $classTitle) == 1) {
            if ($isTeacher) {
                $resultText = ClassModel::createClassWithTitleAndTeacher($classTitle, $teacherID);
                $resultJSON = json_encode($resultText);
                $this->View->renderJSON($resultJSON);
            }
        }
    }

    /**
     * Name: editClassAddStudent_action
     * Description:
     * When add student button is clicked this is called
     * @author Ethan Mata
     * @Date 2/27/2015
     * @return boolean
     */
    public function editClassAddStudent_action() {
        Auth::checkAuthentication();
        // Create a new student:
        // Get the parameters from post
        $fname = Request::post('fname');
        $lname = Request::post('lname');
        $email = Request::post('email');
        $classID = Request::post('classID');
        if (isset($fname) && isset($lname) && isset($email) && isset($classID)) {

            // Make sure the email is not already in use
            if (AccountModel::doesEmailAlreadyExist($email)) {
                Session::add('feedback_negative', Text::get('FEEDBACK_ADD_STUDENT_EMAIL_IN_USE'));
                return false;
            }

            // Set the default password hash for the student
            $password_hash = 'blank';
            // Generate the activation hash:
            $activation_hash = RegistrationModel::generateActivationHash();
            // Add the student to the database
            $user_id = RegistrationModel::writeNewUserToDatabase($fname, $lname, $email, $password_hash, $activation_hash, 'Student');
            // Send a verification email:
            RegistrationModel::sendVerificationEmail($user_id, $email, $activation_hash);
            // Enroll the student
            ClassModel::enrollStudentInClass($user_id, $classID);
            // Create a record in the login attempts table for this student
            LoginModel::createLoginRecordForStudent($user_id);

            $response_array['status'] = 'success';

            echo json_encode($response_array);
        }
    }

    /**
     * Name: removeStudent_action
     * Description:
     * When remove student button is clicked this is called
     * @author Ethan Mata
     * @Date 3/16/2015
     */
    public function removeStudent_action() {
        Auth::checkAuthentication();
        $userID = Request::post('studentID');
        if (isset($userID)) {
            AccountModel::markUserInactive($userID);
        }
    }

    /**
     * Name: removeClass_action
     * Description:
     * When remove class button is clicked this is called
     * @author Ethan Mata
     * @Date 3/16/2015
     */
    public function removeClass_action() {
        Auth::checkAuthentication();
        $classID = Request::post('classID');
        if (isset($classID)) {
            ClassModel::removeClassAndRecords($classID);
        }
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
        Auth::checkAuthentication();
        $teacherID = Session::get('user_id');
        $isTeacher = AccountModel::isTeacher(Session::get('user_role'));
        $classID = Request::get('classID');
        if (isset($teacherID) && isset($isTeacher) && isset($classID)) {
            if ($isTeacher) {
                if (ClassModel::isClassTaughtByTeacher($classID, $teacherID)) {
                    $allStudentsInClassProgress = ClassModel::getAllStudentsInClassProgress($classID);
                    $className = ClassModel::getClassName($classID, $teacherID);
                    $allStudentsInClassProgress["className"] = $className;
                    $this->View->render('class/viewClass', $allStudentsInClassProgress);
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

}
