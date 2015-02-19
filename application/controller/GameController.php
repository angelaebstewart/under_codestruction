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
        if (GameModel::canViewGame(Request::get('id'))) {
            $this->View->render('lesson/viewGame');
        } else {
            Redirect::to('lesson/index');
        }
    }

}
