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
     * @param string $user_name username
     * @param string $verification_code password reset verification token
     */
    public function verifyPasswordReset($user_name, $verification_code) {
        // check if this the provided verification code fits the user's verification code
        if (PasswordResetModel::verifyPasswordReset($user_name, $verification_code)) {
            // pass URL-provided variable to view to display them
            $this->View->render('login/changePassword', array(
                'user_name' => $user_name,
                'user_password_reset_hash' => $verification_code
            ));
        } else {
            Redirect::to('login/index');
        }
    }

    /**
     * Set the new password
     * Please note that this happens while the user is not logged in. The user identifies via the data provided by the
     * password reset link from the email, automatically filled into the <form> fields. See verifyPasswordReset()
     * for more. Then (regardless of result) route user to index page (user will get success/error via feedback message)
     * POST request !
     * TODO this is an _action
     */
    public function setNewPassword() {
        PasswordResetModel::setNewPassword(
                Request::post('user_name'), Request::post('user_password_reset_hash'), Request::post('user_password_new'), Request::post('user_password_repeat')
        );
        Redirect::to('login/index');
    }

    /**
     * Verify user after activation mail link opened
     * @param int $user_id user's id
     * @param string $user_activation_verification_code user's verification token
     */
    public function verify($user_id, $user_activation_verification_code) {
        if (isset($user_id) && isset($user_activation_verification_code)) {
            RegistrationModel::verifyNewUser($user_id, $user_activation_verification_code);
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
        PasswordResetModel::requestPasswordReset(Request::post('user_name_or_email'));
        Redirect::to('login/index');
    }

    /**
     * Register page action
     * POST-request after form submit
     */
    public function register_action($user_type) {
        $registration_successful = RegistrationModel::registerNewUser($user_type);

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

    /**
     * Show edit-my-username page
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     */
    public function editUsername() {
        Auth::checkAuthentication();
        $this->View->render('login/editUsername');
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
        Auth::checkAuthentication();
        AccountModel::editUserEmail(Request::post('user_email'));
        Redirect::to('login/editUserEmail');
    }

    /**
     * Show the change-account-type page
     * Auth::checkAuthentication() makes sure that only logged in users can use this action and see this page
     */
    public function changeAccountType() {
        Auth::checkAuthentication();
        $this->View->render('login/changeAccountType');
    }

    /**
     * Perform the account-type changing
     * Auth::checkAuthentication() makes sure that only logged in users can use this action
     * POST-request
     */
    public function changeAccountType_action() {
        Auth::checkAuthentication();

        if (Request::post('user_account_upgrade')) {
            AccountTypeModel::changeAccountTypeUpgrade();
        }
        if (Request::post('user_account_downgrade')) {
            AccountTypeModel::changeAccountTypeDowngrade();
        }

        Redirect::to('login/changeAccountType');
    }

}
