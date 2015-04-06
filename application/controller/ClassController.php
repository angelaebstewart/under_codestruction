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

    public function edit() {
        $classID = Request::get('classID');
        $studentList = ClassModel::getStudentsFromClass($classID);
        $this->View->render('class/editClass', $studentList);
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

    public function editClassAddStudent_action() {
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
            //RegistrationModel::sendVerificationEmail($user_id, $email, $activation_hash);
            PasswordResetModel::sendPasswordResetMail($user_id, $activation_hash, $email);
            // Enroll the student
            ClassModel::enrollStudentInClass($user_id, $classID);
            // Create a record in the login attempts table for this student
            LoginModel::createLoginRecordForStudent($user_id);
            
            $response_array['status'] = 'success';

            echo json_encode($response_array);
        }
    }
  
    public function removeStudent_action() {
        
        $userID = Request::post('studentID');
        if (isset($userID)) {
            AccountModel::markUserInactive($userID);
        }
    }
    
    public function removeClass_action() {
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
        if (LoginModel::isUserLoggedIn()) {
            $teacherID = Session::get('user_id');
            $isTeacher = AccountModel::isTeacher(Session::get('user_role'));
            $classID = Request::get('classID');
            if (isset($teacherID) && isset($isTeacher) && isset($classID)) {
                if ($isTeacher) {
                    if (ClassModel::isClassTaughtByTeacher($classID, $teacherID)) {
                        $allStudentsInClassProgress = ClassModel::getAllStudentsInClassProgress($classID);
                        $className = ClassModel::getClassName($classID, $teacherID);
                        $allStudentsInClassProgress["className"]=$className;
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
        } else {
            Redirect::to("error/index");
        }
    }

}
