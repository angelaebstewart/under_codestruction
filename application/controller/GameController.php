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
            if (GameModel::canViewGame($userID, $userRole, Request::get('id'))&&Request::get('page') === "1") {
                $this->View->render('lesson/viewGame');
            } 
            
            else if (GameModel::canViewGame($userID, $userRole, Request::get('id'))&&Request::get('page') === "2") {
                $this->View->render('lesson/page2');
            }

            else if (GameModel::canViewGame($userID, $userRole, Request::get('id'))&&Request::get('page') === "3") {
                $this->View->render('lesson/page3');
            }            

            else if (GameModel::canViewGame($userID, $userRole, Request::get('id'))&&Request::get('page') === "4") {
                $this->View->render('lesson/page4');
            }
            
            else {
                Redirect::to('lesson/index');
            }
        } else {
            $this->View->render('error/index');
        }
    }

}
