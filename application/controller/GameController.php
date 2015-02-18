<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GameController
 *
 * @author WalterC
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
        if (LessonModel::canViewGame(Request::get('id'))) {
            $this->View->render('lesson/viewGame');
        } else {
            Redirect::to('lesson/index');
        }
    }

}
