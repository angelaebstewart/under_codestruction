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
     * Handles what happens when user moves to URL/index/index - or - as this is the default controller, also
     * when user moves to /index or enter your application at base level
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     */
    public function index() {
        $this->View->render('index/index');
    }

    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     */
    public function about() {

        $this->View->render('index/about');
    }

    /**
     * SEARCH-KEYWORD: NOT COMMENTED
     * Name: ?
     * Description:
     * ?
     * @author ?
     * @Date ?
     */
    public function faq() {
        $this->View->render('index/faq');
    }

}
