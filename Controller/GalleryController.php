<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 21.05.2016
 * Time: 13:55
 */

namespace MKWeb\ImgDB\Controller;


use MKWeb\ImgDB\Model\Gallery;
use MKWeb\ImgDB\Model\User;

class GalleryController extends Controller
{

    public function index() {
        
    }
    
    public function add() {
        if (!isset($this->request->params['passed']['gallery_add_name']) &&
            !isset($this->request->params['passed']['gallery_add_description'])) {
            return $this->redirect(ROOT . '/index/index?flash=Some essential information is missing.&title=Could not create a new gallery.');
        }
        $name = h($this->request->params['passed']['gallery_add_name']);
        $description = nl2br(h($this->request->params['passed']['gallery_add_description']));
        $private = isset($this->request->params['passed']['gallery_add_private']) && $this->request->params['passed']['gallery_add_private'] === 'private';
        $gallery = new Gallery();
        $gallery->setUserById(intval($this->request->session['user_id']));
        $gallery->setName($name);
        $gallery->setDescription($description);
        $gallery->setPrivate($private);
        $gallery->create();
        $this->redirect(ROOT . '/index/index');
    }

}