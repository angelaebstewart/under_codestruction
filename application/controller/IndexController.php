<?php

/**
 * Description of IndexController
 */
class IndexController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Name: index
     * Description:
     * Handles what happens when user moves to URL/index/index - or - as this is the default controller, also
     * when user moves to /index or enter your application at base level
     * @author FRAMEWORK
     * @Date ?
     */
    public function index() {
        $this->View->render('index/index');
    }

    /**
     * Name: about
     * Description:
     * Shows the About page
     * @author Walter Conway
     * @Date ?
     */
    public function about() {

        $this->View->render('index/about');
    }

    /**
     * Name: faq
     * Description:
     * Shows the FAQ page
     * @author Ryan Lewis
     * @Date ?
     */
    public function faq() {
        $this->View->render('index/faq');
    }

}
