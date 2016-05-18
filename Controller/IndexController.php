<?php
include_once('Controller.php');


class IndexController extends Controller {


    public function index() {

        if (!empty($this->request->session['user_id'])) {
            $this->template = $this->_setTemplate('inside');
        }
        /* if the user is loggedin it will redirect the user to the blogs page */
        //return isset($this->request->session['user_id']) ? $this->redirect(ROOT . '/index/index') : null;
    }
}
