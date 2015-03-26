<?php
/**
 * Description of AccountController
 *
 * @author WalterC
 */
class AccountController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Verify the verification token of that user (to show the user the password editing view or not)
     * @param string $user_id user id
     * @param string $verification_code password reset verification token
     */
    public function verifyPasswordReset($user_id, $verification_code) {
        // check if this the provided verification code fits the user's verification code
        if (PasswordResetModel::verifyPasswordReset($user_id, $verification_code)) {
            Session::set('user_id', $user_id);
            Session::set('verification_code', $verification_code);
            $this->View->render('login/changePassword');
        } else {            
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_COMBINATION_DOES_NOT_EXIST'));
            Redirect::to('login/index');
        }
    }

    public function changePassword_action(){
        $user_id = Session::get('user_id');
        $verification_code = Session::get('verification_code');
        $passwordNew = Request::post('password1');
        $passwordRetyped = Request::post('password2');
        if(isset($user_id) && isset($verification_code) && isset($passwordNew) && isset($passwordRetyped)){
            if(($passwordNew == $passwordRetyped)&& (strlen($passwordNew) >= 6 && strlen($passwordRetyped) >= 6)){
                PasswordResetModel::setNewPassword($user_id, $verification_code, $passwordNew, $passwordRetyped);
                $this->View->render('login/index');
            } else{
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
                $this->View->render('login/changePassword');
            }
        } else{
        $this->View->render('error/index');
        }
    }
    /**
     * Show edit-my-user-email page
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     */
    public function editPassword() {
        Auth::checkAuthentication();
        $this->View->render('login/editPassword');
    }
    
    public function editPassword_action(){
        $user_id = Session::get('user_id');
        $verification_code = '';
        $passwordNew = Request::post('password1');
        $passwordRetyped = Request::post('password2');
        if(isset($user_id) /*&& isset($verification_code)*/ && isset($passwordNew) && isset($passwordRetyped)){
            if(($passwordNew == $passwordRetyped)&& (strlen($passwordNew) >= 6 && strlen($passwordRetyped) >= 6)){
                ChangePasswordModel::setNewPassword($user_id, $passwordNew, $passwordRetyped);
                Redirect::to('login/index');
            } else{
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
                $this->View->render('login/editPassword');
            }
        } else{
        $this->View->render('error/index');
        }
    }

    /**
     * Verify user after activation mail link opened
     * @param int $user_id user's id
     * @param string $user_activation_verification_code user's verification token
     */
    public function verify($user_id, $user_activation_verification_code) {
        if (isset($user_id) && isset($user_activation_verification_code)) {
            RegistrationModel::verifyNewUser($user_id, $user_activation_verification_code);
            AccountModel::createLoginRecord($user_id);
            $this->View->render('login/verify');
        } else {
            Redirect::to('login/index');
        }
    }

    /**
     * Show the request-password-reset page
     */
    public function requestPasswordReset() {
        $this->View->render('login/requestPasswordReset');
    }

    /**
     * The request-password-reset action
     * POST-request after form submit
     */
    public function requestPasswordReset_action() {
        //Retrieves the user name or e-mail variable from the session
        $userName = Request::post('user_name_or_email');
        if (empty($userName)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_EMAIL_FIELD_EMPTY'));
            $this->View->render('login/requestPasswordReset');
            return;
        }
        $result = AccountModel::getUserIdByUsername($userName);
        if ($result == -1) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USER_DOES_NOT_EXIST'));
            $this->View->render('login/requestPasswordReset');
            return;
        }
        
        PasswordResetModel::requestPasswordReset($userName);
        Redirect::to('login/index');
    }
      /**
     * The request-password-reset action
     * POST-request after form submit
     */
    public function requestEmailReset_action() {
        //Retrieves the user name or e-mail variable from the session
        $userName = Request::post('user_name_or_email');
        $newUserName = Request::post('new_user_name_or_email');
        if (empty($userName) || empty($newUserName)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_EMAIL_FIELD_EMPTY'));
            $this->View->render('login/editUserEmail');
            return;
        }
        $result = AccountModel::getUserIdByUsername($userName);
        if ($result == -1) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USER_DOES_NOT_EXIST'));
            $this->View->render('login/editUserEmail');
            return;
        }
        
        ChangeEmailModel::requestEmailReset($userName, $newUserName);
        Redirect::to('login/index');
    }
    
    /**
     * Verify the verification token of that user (to show the user the password editing view or not)
     * @param string $user_id user id
     * @param string $verification_code password reset verification token
     */
    public function verifyEmailReset($user_id, $verification_code, $user_email) {
        // check if this the provided verification code fits the user's verification code
        if (ChangeEmailModel::verifyEmailReset($user_id, $verification_code)) {
            Session::set('user_id', $user_id);
            Session::set('verification_code', $verification_code);
            Session::set('user_email', $user_email);
            ChangeEmailModel::saveNewUserEmail($user_id, $user_email, $verification_code);
            Redirect::to('login/index');
        } else {            
            Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_COMBINATION_DOES_NOT_EXIST'));
            Redirect::to('login/index');
        }
    }
    
   /**
     * Register page action
     * POST-request after form submit
     */
    public function register_action() {
        
        $registration_successful = RegistrationModel::registerNewUser('Teacher');

        if ($registration_successful) {
            Redirect::to('login/index');
        } else {
            Redirect::to('login/register');
        }
    }

    /**
     * Register page
     * Show the register form, but redirect to main-page if user is already logged-in
     */
    public function register() {
        if (LoginModel::isUserLoggedIn()) {
            Redirect::home();
        } else {
            $this->View->render('login/register');
        }
    }

    /**
     * Show user's PRIVATE profile
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     */
    public function profile() {
        Auth::checkAuthentication();

        if (Session::get('user_role') == Config::get('ROLE_TEACHER', 'gen')) {
            $roleName = 'Teacher';
        } else {
            $roleName = 'Student';
        }

        $this->View->render('login/profile', array(
            'user_firstName' => Session::get('user_firstName'),
            'user_lastName' => Session::get('user_lastName'),
            'user_email' => Session::get('user_email'),
            'user_roleName' => $roleName
        ));
    }
    
    public function options() {
        Auth::checkAuthentication();
        $this->View->render('login/options');
    }

    public function options_deleteAccountAction() {
        $user_id = Session::get('user_id');
        if (Session::get('user_role') == Config::get('ROLE_TEACHER', 'gen') && isset($user_id)) {
            AccountModel::deleteTeacherAccount($user_id);
            LoginModel::logout();
            Redirect::to('login/index');
        }
    }
    
    
    /**
     * Show edit-my-username page
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     */
    public function editUsername() {
        Redirect::to('login/index');
        //Auth::checkAuthentication();
        //$this->View->render('login/editUsername');
    }

    /**
     * Edit user name (perform the real action after form has been submitted)
     * Auth::checkAuthentication() makes sure that only logged in users can use this action
     */
    public function editUsername_action() {
        Auth::checkAuthentication();
        AccountModel::editUserName(Request::post('user_name'));
        Redirect::to('login/index');
    }

    /**
     * Show edit-my-user-email page
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     */
    public function editUserEmail() {
        Auth::checkAuthentication();
        $this->View->render('login/editUserEmail');
    }

    /**
     * Edit user email (perform the real action after form has been submitted)
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     */
    // make this POST
    public function editUserEmail_action() {
        /*Auth::checkAuthentication();
        AccountModel::editUserEmail(Request::post('user_email'));
        Redirect::to('login/editUserEmail');*/
        $user_id = Session::get('user_id');
        $passwordNew = Request::post('password1');
        $passwordRetyped = Request::post('password2');
        if(isset($user_id) && isset($passwordNew) && isset($passwordRetyped)){
            if(($passwordNew == $passwordRetyped)&& (strlen($passwordNew) >= 6 && strlen($passwordRetyped) >= 6)){
                PasswordResetModel::setNewPassword($user_id, $passwordNew, $passwordRetyped);
                $this->View->render('login/index');
            } else{
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
                $this->View->render('login/requestEmailChange');
            }
        } else{
        $this->View->render('error/index');
        }
    }
}