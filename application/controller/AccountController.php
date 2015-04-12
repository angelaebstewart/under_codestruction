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
                $this->View->render('login/changePassword');
            } else {
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_RESET_COMBINATION_DOES_NOT_EXIST'));
                Redirect::to('login/index');
            }
        } else {
            $this->View->render('error/index');
        }
    }

    /**
     * Name: changePassword_action
     * Description:
     * When the change password button is clicked this action is called. (changePassword.php L6)
     * @author ?
     * @Date 4/9/2015
     */
    public function changePassword_action() {
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
                $this->View->render('login/changePassword');
            }
        } else {
            $this->View->render('error/index');
        }
    }

    /**
     * Name: editPassword
     * Description:
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     * Show This shows the editPassword Page...
     * @author FRAMEWORK
     * @Date ?
     */
    public function editPassword() {
        Auth::checkAuthentication();
        $this->View->render('login/editPassword');
    }

    /**
     * Name: editPassword_action
     * Description:
     * When the edit password button is clicked.
     * @author Victoria Richardson
     * @Date 4/9/2015
     */
    public function editPassword_action() {
        if (LoginModel::isUserLoggedIn()) {
            $user_id = Session::get('user_id');
            $passwordNew = Request::post('password1');
            $passwordRetyped = Request::post('password2');
            if (isset($user_id) && isset($passwordNew) && isset($passwordRetyped)) {
                if (($passwordNew == $passwordRetyped) && (strlen($passwordNew) >= 6 && strlen($passwordRetyped) >= 6)) {
                    ChangePasswordModel::setNewPassword($user_id, $passwordNew, $passwordRetyped);
                    Redirect::to('login/index');
                } else {
                    Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
                    $this->View->render('login/editPassword');
                }
            } else {
                $this->View->render('error/index');
            }
        } else {
            $this->View->render('error/index');
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
            if (RegistrationModel::verifyNewUser($user_id, $user_activation_verification_code)) {
                Session::add('feedback_positive', Text::get('FEEDBACK_ACCOUNT_ACTIVATION_SUCCESSFUL'));
                try {
                    AccountModel::createLoginRecord($user_id);
                } catch (InvalidArgumentException $e) {
                    Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_ACTIVATION_FAILED'));
                    Redirect::to('login/index');
                    return;
                }
            } else {
                Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_ACTIVATION_FAILED'));
                Redirect::to('login/index');
                return;
            }
            $this->View->render('login/index');
        } else {
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
     * The request-password-reset action
     * POST-request after form submit
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     */
    public function requestEmailReset_action() {
        //Retrieves the user name or e-mail variable from the session
        $userName = Request::post('email');
        $newUserName = Request::post('new_email');
        if (empty($userName) || empty($newUserName)) {
            Session::add('feedback_negative', Text::get('FEEDBACK_USERNAME_EMAIL_FIELD_EMPTY'));
            $this->View->render('login/editUserEmail');
            return;
        }
        $result = AccountModel::getUserIdByEmail($userName);
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
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
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
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     */
    public function register_action() {

        $registration_successful = RegistrationModel::registerNewUser('Teacher');

        if ($registration_successful) {
            Redirect::to('login/index');
        } else {
            Redirect::to('account/register');
        }
    }

    /**
     * Register page
     * Show the register form, but redirect to main-page if user is already logged-in
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
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
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
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

    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     */
    public function options() {
        Auth::checkAuthentication();
        $this->View->render('login/options');
    }

    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     */
    public function options_deleteAccountAction() {
        $user_id = Session::get('user_id');
        if (Session::get('user_role') == Config::get('ROLE_TEACHER', 'gen') && isset($user_id)) {
            AccountModel::deleteTeacherAccount($user_id);
            LoginModel::logout();
            Redirect::to('login/index');
        }
    }

    /**
     * Show edit-my-user-email page
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
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
     * @author Victoria Richardson
     * @Date 4/9/2015
     */
    public function editUserEmail_action() {
        /* Auth::checkAuthentication();
          AccountModel::editUserEmail(Request::post('user_email'));
          Redirect::to('login/editUserEmail'); */
        $user_id = Session::get('user_id');
        $passwordNew = Request::post('password1');
        $passwordRetyped = Request::post('password2');
        if (isset($user_id) && isset($passwordNew) && isset($passwordRetyped)) {
            if (($passwordNew == $passwordRetyped) && (strlen($passwordNew) >= 6 && strlen($passwordRetyped) >= 6)) {
                PasswordResetModel::setNewPassword($user_id, $passwordNew, $passwordRetyped);
                $this->View->render('login/index');
            } else {
                Session::add('feedback_negative', Text::get('FEEDBACK_PASSWORD_CHANGE_FAILED'));
                $this->View->render('login/requestEmailChange');
            }
        } else {
            $this->View->render('error/index');
        }
    }

}
