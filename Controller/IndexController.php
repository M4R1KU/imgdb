<?php
namespace MKWeb\ImgDB\Controller;

use MKWeb\ImgDB\Model\Gallery;
use MKWeb\ImgDB\Model\User;

class IndexController extends Controller {


    public function index() {

        if (!empty($this->request->session['user_id'])) {
            $this->template = $this->_setTemplate('inside');
            $user = (new User())->readById($this->request->session['user_id']);
            $out = (new Gallery())->getGalleriesByUser($user);
            $galleries = [];
            if (count($out) >= 3) {
                $j = 0;
                for ($i = 0; $i < count($out); $i++) {
                    $galleries[$j][] = $out[$i];
                    if (($i+1) % 3 == 0) $j++;
                }
            } else {
                $galleries[0] = $out;
            }
            
            $this->view->assign('user_galleries', $galleries);
        }
        /* if the user is loggedin it will redirect the user to the blogs page */
        //return isset($this->request->session['user_id']) ? $this->redirect(ROOT . '/index/index') : null;
    }
}
