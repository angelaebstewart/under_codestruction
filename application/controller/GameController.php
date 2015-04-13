<?php

/**
 * Called when a user views a game page.
 */
class GameController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Name: viewGame
     * Description:
     * Called when a user clicks the game link on a lesson page. Renders the
     * page that the game data will later be loaded onto.
     * @author Ryan Lewis
     */
    public function viewGame() {
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');
        $lessonID = Request::get('id');

        if (isset($userID) && isset($userRole) && isset($lessonID)) {
            if (GameModel::canViewGame($userID, $userRole, $lessonID)) {
                LessonModel::recordViewedGame($userID, $lessonID);
                $this->View->render('lesson/viewGame');
            } else {
                Redirect::to('lesson/index');
            }
        } else {
            Redirect::to('error/index');
        }
    }

    /**
     * Name: getGamePage_action
     * Description:
     * Called when a user submits a game page. Loads the next game page, or
     * a message that tells them they have completed the game.
     * @author Ryan Lewis
     */
    public function getGamePage_action() {
        $gameID = Request::post('gameID');
        $nextPage = Request::post('nextPage');
        $userID = Session::get('user_id');
        $userRole = Session::get('user_role');

        if (isset($userID) && isset($userRole)) {
            if (GameModel::canViewGame($userID, $userRole, $gameID)) {
                $pageFile = "../application/view/lesson/" . $gameID . "/page" . $nextPage . ".php";

                if (file_exists($pageFile)) {
                    $response_array['pageData'] = file_get_contents($pageFile);
                    $response_array['finished'] = "0";
                } else {
                    $response_array['pageData'] = "You completed the lesson!";
                    $response_array['finished'] = "1";
                }

                echo json_encode($response_array);
            } else {
                Redirect::to('lesson/index');
            }
        } else {
            Redirect::to('error/index');
        }
    }

}
