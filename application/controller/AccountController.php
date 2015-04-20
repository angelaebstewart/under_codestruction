<?php

/**
 * Description of AccountController
 *
 */
class AccountController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Name: verifyPasswordReset
     * Description:
     * Verify the verification token of that user (to show the user the password editing view or not)
     * @author FRAMEWORK(modified: Walter Conway)
     * @Date 4/9/2015
     * @param string $user_id user id
     * @param string $verification_code password reset verification token
     */
    public function verifyPasswordReset($user_id, $verification_code) {
        if (isset($user_id) && isset($verification_code)) {
            // check if this the provided verification code fits the user's verification code
            if (PasswordResetModel::verifyPasswordReset($user_id, $verification_code)) {
                Session::set('user_id', $user_id);
                Session::set('verification_code', $verification_code);
                $this->View->render('login/resetPassword');
            } else {
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_COMBINATION_DOES_NOT_EXIST'));
                Redirect::to('login/index');
            }
        } else {
            $this->View->render('error/index');
        }
    }

    /**
     * Name: resetPassword_action
     * Description:
     * When the change password button is clicked this action is called. (resetPassword.php L6)
     * @author ?
     * @Date 4/9/2015
     */
    public function resetPassword_action() {
        $user_id = Session::get('user_id');
        $verification_code = Session::get('verification_code');
        $passwordNew = Request::post('password1');
        $passwordRetyped = Request::post('password2');
        if (isset($user_id) && isset($verification_code) && isset($passwordNew) && isset($passwordRetyped)) {
            if (($passwordNew == $passwordRetyped) && (strlen($passwordNew) >= 6 && strlen($passwordRetyped) >= 6)) {
                PasswordResetModel::setNewPassword($user_id, $verification_code, $passwordNew, $passwordRetyped);
                $this->View->render('login/index');
            } else {
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
                $this->View->render('login/resetPassword');
            }
        } else {
            $this->View->render('error/index');
        }
    }

    /**
     * Name: changePassword
     * Description:
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     * Show This shows the changePassword Page...
     * @author FRAMEWORK
     * @Date ?
     */
    public function changePassword() {
        Auth::checkAuthentication();
        $this->View->render('login/changePassword');
    }

    /**
     * Name: changePassword_action
     * Description:
     * When the edit password button is clicked.
     * @author Victoria Richardson
     * @Date 4/9/2015
     */
    public function changePassword_action() {
        //Auth::checkAuthentication();
        $user_id = Session::get('user_id');
        $passwordNew = Request::post('password1');
        $passwordRetyped = Request::post('password2');
        if (isset($user_id) && isset($passwordNew) && isset($passwordRetyped)) {
            if (($passwordNew == $passwordRetyped) && mb_strlen($passwordNew) >= 6) {
                ChangePasswordModel::setNewPassword($user_id, $passwordNew, $passwordRetyped);
                Redirect::to('login/index');
            } else {
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
                $this->View->render('login/changePassword');
            }
        /*} else {
            $this->View->render('error/index');
        }*/
    }
    }

    /**
     * Name: verify
     * Description:
     * Verify user after activation mail link opened
     * @author Walter Conway
     * @Date 4/11/2015
     * @param int $user_id user's id
     * @param string $user_activation_verification_code user's verification token
     */
    public function verify($user_id, $user_activation_verification_code) {
        if (isset($user_id) && isset($user_activation_verification_code)) {
            
            if (RegistrationModel::verifyNewUser($user_id, $user_activation_verification_code)){
                Session::add('feedback_positive', Text::get('FEEDBACK_ACCOUNT_ACTIVATION_SUCCESSFUL'));
                try {
                    AccountModel::createLoginRecord($user_id);
                } catch (InvalidArgumentException $e) {
                    Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_ACTIVATION_FAILED'));
                    Redirect::to('login/index');
                    return;
                }
                Session::set('user_id', $user_id);
                Session::set('verification_code', $user_activation_verification_code);
                $role = AccountModel::getUserRoleByID($user_id);
           
                if ($role == "1"){
            //RegistrationModel::verifyNewUser($user_id, $user_activation_verification_code);
            //AccountModel::createLoginRecord($user_id);
                    $this->View->render('login/changePassword');
                }
                else if ($role == "2"){
                //RegistrationModel::verifyNewUser($user_id, $user_activation_verification_code);
                //AccountModel::createLoginRecord($user_id);
                    $this->View->render('login/index');
                }
                else{
                    Redirect::to('error/index');
                }
                }
            
        } 
        else {
            Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_ACTIVATION_FAILED'));
            Redirect::to('login/index');
        }
    }

    /**
     * Name: requestPasswordReset
     * Description:
     * Show the request-password-reset page
     * @author FRAMEWORK
     * @Date 4/11/2015
     */
    public function requestPasswordReset() {
        $this->View->render('login/requestPasswordReset');
    }

    /**
     * Name: requestPasswordReset_action
     * Description:
     * Processes the password reset Action from.
     * @author FRAMEWORK (modified: Walter Conway)
     * @Date 4/11/2015
     */
    public function requestPasswordReset_action() {
        //Retrieves the user name or e-mail variable from the session
        $userName = Request::post('email');
        if (empty($userName)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_EMAIL_FIELD_EMPTY'));
            $this->View->render('login/requestPasswordReset');
            return;
        }
        $result = AccountModel::getUserIdByEmail($userName);
        if ($result == -1) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USER_DOES_NOT_EXIST'));
            $this->View->render('login/requestPasswordReset');
            return;
        }
        PasswordResetModel::requestPasswordReset($userName);
        Redirect::to('login/index');
    }

    /**
     * Name: requestEmailReset_action
     * Description:
     * When the Email reset button is clicked.
     * @author FRAMEWORK (modified: Walter Conway & Victoria Richardson)
     * @Date 4/12/2015
     * @return type
     */
    public function requestEmailReset_action() {
        //Retrieves the user name or e-mail variable from the session
        $email = Request::post('email');
        $newEmail = Request::post('new_email');
        if (empty($email) || empty($newEmail)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_EMAIL_FIELD_EMPTY'));
            $this->View->render('login/editUserEmail');
            return;
        }
        $result = AccountModel::doesEmailAlreadyExist($email);
        if (!$result) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USER_DOES_NOT_EXIST'));
            $this->View->render('login/editUserEmail');
            return;
        }

        if (!ChangeEmailModel::requestEmailReset($email, $newEmail))
            Redirect::to('account/options');
        else
            Redirect::to('login/index');
    }

    /**
     * Name: verifyEmailReset
     * Description:
     * Verify the verification token of that user (to show the user the password editing view or not)
     * @author FRAMEWORK (modified Walter Conway)
     * @Date 4/11/2015
     * @param string $user_id user id
     * @param string $verification_code password reset verification token
     */
    public function verifyEmailReset($user_id, $verification_code, $user_email) {
        if (isset($user_id) && isset($verification_code) && isset($user_email)) {
            // check if this the provided verification code fits the user's verification code
            if (ChangeEmailModel::verifyEmailReset($user_id, $verification_code)) {
                Session::set('user_id', $user_id);
                Session::set('verification_code', $verification_code);
                Session::set('user_email', $user_email);
                if (!ChangeEmailModel::saveNewUserEmail($user_id, $user_email, $verification_code)) {
                    Session::add('feedback_negative', Text::get('FEEDBACK_NEW_USER_EMAIL_FAILED'));
                }
                Redirect::to('login/index');
            } else {
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_COMBINATION_DOES_NOT_EXIST'));
                Redirect::to('login/index');
            }
        } else {
            Redirect::to('login/index');
        }
    }

    /**
     * Name: register_action
     * Description:
     * When a user is registered as a teacher.
     * @author FRAMEWORK (modified: Walter Conway)
     * @Date 4/12/2015
     * NOTE: Consider taking user type "Teacher"
     */
    public function register_action() {

        $user_firstName = strip_tags(Request::post('user_firstName'));
        $user_lastName = strip_tags(Request::post('user_lastName'));
        $user_email = strip_tags(Request::post('user_email'));
        $user_password_new = Request::post('user_password_new');
        $user_password_repeat = Request::post('user_password_repeat');
        $captcha = Request::post('captcha');

        if (isset($user_firstName) && isset($user_lastName) &&
                isset($user_email) && isset($user_password_new) &&
                isset($user_password_repeat) && isset($captcha)) {
            $validation_result = RegistrationModel::registrationInputValidation($captcha, $user_firstName, $user_lastName, $user_email, $user_password_new, $user_password_repeat);
            if ($validation_result) {
                $registration_successful = RegistrationModel::registerNewUser($user_firstName, $user_lastName, $user_email, $user_password_new, "Teacher");
                if ($registration_successful) {
                    Redirect::to('login/index');
                } else {
                    Redirect::to('account/register');
                }
            } else {
                Redirect::to('account/register');
            }
        }
    }

    /**
     * Name: register
     * Description:
     * Show the register form, but redirect to main-page if user is already logged-in
     * @author FRAMEWORK
     * @Date ?
     */
    public function register() {
        if (Session::userIsLoggedIn()) {
            Redirect::home();
        } else {
            $this->View->render('login/register');
        }
    }

    /**
     * Name: options
     * Description:
     * Shows the optiosn to the teacher or student
     * @author FRAMEWORK
     * @Date ?
     */
    public function options() {
        Auth::checkAuthentication();
        $this->View->render('login/options');
    }

    /**
     * Name: options_deleteAccountAction
     * Description:
     * When the delete account button is clicked this method is called.
     * @author Ethan Mata (modified: Walter Conway, added checkAuthentication)
     * @Date ?
     */
    public function options_deleteAccountAction() {
        Auth::checkAuthentication();
        $user_id = Session::get('user_id');
        if (Session::get('user_role') == Config::get('ROLE_TEACHER', 'gen') && isset($user_id)) {
            AccountModel::deleteTeacherAccount($user_id);
            LoginModel::logout();
            Redirect::to('login/index');
        }
    }

    /**
     * Name: editUserEmail
     * Description:
     * Show edit-my-user-email page
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     * @author FRAMEWORK
     * @Date ?
     */
    public function editUserEmail() {
        Auth::checkAuthentication();
        $this->View->render('login/editUserEmail');
    }

    /**
     * Name: editUserEmail_action
     * Description:
     * Edit user email (perform the real action after form has been submitted)
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     * @author Victoria Richardson (modified: Walter Conway, setNewPassword if it fails)
     * @Date 4/9/2015
     */
    public function editUserEmail_action() {
        Auth::checkAuthentication();
        $user_id = Session::get('user_id');
        $passwordNew = Request::post('password1');
        $passwordRetyped = Request::post('password2');
        if (isset($user_id) && isset($passwordNew) && isset($passwordRetyped)) {
            if (($passwordNew == $passwordRetyped) && (strlen($passwordNew) >= 6 && strlen($passwordRetyped) >= 6)) {
                if(PasswordResetModel::setNewPassword($user_id, $passwordNew, $passwordRetyped)){
                    $this->View->render('login/index');
                }else{
                    Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
                    $this->View->render('login/requestEmailChange');
                }
            } else {
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
                $this->View->render('login/requestEmailChange');
            }
        } else {
            $this->View->render('error/index');
        }
    }

}
