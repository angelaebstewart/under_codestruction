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
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
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
            $this->View->render('error/index');
        }
    }

    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
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
            $this->View->render('error/index');
        }
    }

}
