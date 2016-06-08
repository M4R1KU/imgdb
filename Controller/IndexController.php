<?php
namespace MKWeb\ImgDB\Controller;

use MKWeb\ImgDB\Model\Entity\User;
use MKWeb\ImgDB\Model\GalleryTable;
use MKWeb\ImgDB\Model\UserTable;

class IndexController extends Controller {


    public function index() {

        if (!empty($this->request->session['user_id'])) {
            $galleryTable = new GalleryTable();
            $userTable = new UserTable();
            
            $this->template = $this->_setTemplate('inside');
            $user = $userTable->readById($this->request->session['user_id']);
            $private = $galleryTable->getGalleriesByUser($user);
            $public = $galleryTable->getPublicGalleries();
            $private = prepareGalleries($private);
            $public = prepareGalleries($public);
            
            $this->view->assign('user_galleries', $private);
            $this->view->assign('public_galleries', $public);
        }
        /* if the user is loggedin it will redirect the user to the blogs page */
        //return isset($this->request->session['user_id']) ? $this->redirect(ROOT . '/index/index') : null;
    }
}
