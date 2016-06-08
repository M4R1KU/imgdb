<?php
namespace MKWeb\ImgDB\Controller;

use MKWeb\ImgDB\Model\Gallery;
use MKWeb\ImgDB\Model\User;

class IndexController extends Controller {


    public function index() {

        if (!empty($this->request->session['user_id'])) {
            $this->template = $this->_setTemplate('inside');
            $user = (new User())->readById($this->request->session['user_id']);
            $private = (new Gallery())->getGalleriesByUser($user);
            $public = (new Gallery())->getPublicGalleries();
            $private = prepareGalleries($private);
            $public = prepareGalleries($public);
            
            $this->view->assign('user_galleries', $private);
            $this->view->assign('public_galleries', $public);
        }
        /* if the user is loggedin it will redirect the user to the blogs page */
        //return isset($this->request->session['user_id']) ? $this->redirect(ROOT . '/index/index') : null;
    }
}
