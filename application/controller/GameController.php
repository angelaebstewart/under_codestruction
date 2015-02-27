<?php

/**
 * Description of GameController
 *
 */
class GameController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * When you click on a game link, it goes to the game for that lesson.
     */
    public function viewGame() {
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');
        if(isset($userID) && isset($userRole)) {
            if (GameModel::canViewGame($userID, $userRole, Request::get('id'))) {
                $this->View->render('lesson/viewGame');
            } else {
                Redirect::to('lesson/index');
            }
        } else {
            $this->View->render('error/index');
        }
    }

}
