<?php

/**
 * LoginController
 * Controls everything that is authentication-related
 */
class LoginController extends Controller {

    /**
     * Construct this object by extending the basic Controller class. The parent::__construct thing is necessary to
     * put checkAuthentication in here to make an entire controller only usable for logged-in users (for sure not
     * needed in the LoginController).
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Index, default action (shows the login form), when you do login/index
     */
    public function index() {
        // if user is logged in redirect to main-page, if not show the view
        if (LoginModel::isUserLoggedIn()) {
            Redirect::to('login/loginHome');
        } else {
            $this->View->render('login/index');
        }
    }

    /**
     * The login action, when you do login/login
     */
    public function login() {
        // perform the login method, put result (true or false) into $login_successful
        $login_successful = LoginModel::login(
                        Request::post('user_name'), Request::post('user_password')
        );

        // check login status: if true, then redirect user login/showProfile, if false, then to login form again
        if ($login_successful) {
            Redirect::to('login/loginHome');
        } else {
            Redirect::to('login/index');
        }
    }

    public function loginHome() {
        if (AccountModel::isTeacher(Session::get('user_role'))) {
            Redirect::to('class/index');
        } else {
            Redirect::to('lesson/index');
        }
    }

    /**
     * The logout action
     * Perform logout, redirect user to main-page
     */
    public function logout() {
        LoginModel::logout();
        Redirect::home();
    }

    /**
     * Login with cookie
     */
    public function loginWithCookie() {
        // run the loginWithCookie() method in the login-model, put the result in $login_successful (true or false)
        $login_successful = LoginModel::loginWithCookie(Request::cookie('remember_me'));

        // if login successful, redirect to dashboard/index ...
        if ($login_successful) {
            Redirect::to('dashboard/index');
        } else {
            // if not, delete cookie (outdated? attack?) and route user to login form to prevent infinite login loops
            LoginModel::deleteCookie();
            Redirect::to('login/index');
        }
    }

    /**
     * Generate a captcha, write the characters into $_SESSION['captcha'] and returns a real image which will be used
     * like this: <img src="......./login/showCaptcha" />
     * IMPORTANT: As this action is called via <img ...> AFTER the real application has finished executing (!), the
     * SESSION["captcha"] has no content when the application is loaded. The SESSION["captcha"] gets filled at the
     * moment the end-user requests the <img .. >
     * Maybe refactor this sometime.
     */
    public function showCaptcha() {
        CaptchaModel::generateAndShowCaptcha();
    }

}
