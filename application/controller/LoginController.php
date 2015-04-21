<?php

/**
 * LoginController
 * Controls everything that is authentication-related
 */
class LoginController extends Controller {

    /**
     * Construct this object by extending the basic Controller class.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Name: index
     * Description:
     * Index, default action (shows the login form), when you do login/index
     * @author FRAMEWORK (modified by: Ryan Lewis & Walter Conway) 
     * @Date ?
     */
    public function index() {
        // if user is logged in redirect to main-page, if not show the view
        if (Session::userIsLoggedIn()) {
            Redirect::to('login/loginHome');
        } else {
            $this->View->render('login/index');
        }
    }

    /**
     * Name: login
     * Description:
     * The login action, when you do login/login
     * @author Victoria Richardson
     * @Date ?
     */
    public function login() {
        $userName = Request::post('user_name');
        $userPassword = Request::post('user_password');
        if (isset($userName) && isset($userPassword)) {
            // perform the login method, put result (true or false) into $login_successful
            $login_successful = LoginModel::login($userName, $userPassword);

            // check login status: if true, then redirect user login/showProfile, if false, then to login form again
            if ($login_successful) {
                //if the user successfully logs in, reset the count
                $userID = Session::get('user_id');
                LoginModel::validLogin($userID);
                Redirect::to('login/loginHome');
            } else {
                Redirect::to('login/index');
            }
        }
    }

    /**
     * Name: loginHome
     * Description:
     * Directs the student or teacher to their 'home page'
     * @author Ryan Lewis (Modified by: Walter Conway, goto the about page)
     * @Date 4/16/2015
     */
    public function loginHome() {
        Auth::checkAuthentication();
        Redirect::to('index/about');
    }

    /**
     * Name: logout
     * Description:
     * Perform logout, redirect user to main-page
     * @author FRAMEWORK
     * @Date ?
     */
    public function logout() {
        LoginModel::logout();
        Redirect::home();
    }

    /**
     * Name: showCaptcha
     * Description:
     * Generate a captcha, write the characters into $_SESSION['captcha'] and returns a real image which will be used
     * like this: <img src="......./login/showCaptcha" />
     * IMPORTANT: As this action is called via <img ...> AFTER the real application has finished executing (!), the
     * SESSION["captcha"] has no content when the application is loaded. The SESSION["captcha"] gets filled at the
     * moment the end-user requests the <img .. >
     * Maybe refactor this sometime.
     * @author FRAMEWORK
     * @Date ?
     */
    public function showCaptcha() {
        CaptchaModel::generateAndShowCaptcha();
    }

}
