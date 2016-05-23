<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 21.05.2016
 * Time: 13:55
 */

namespace MKWeb\ImgDB\Controller;


use MKWeb\ImgDB\Model\Gallery;

class GalleryController extends Controller
{

    public function index() {
        
    }

    public function delete() {
        if (!isset($this->request->params['passed']['id'])){
            return $this->redirect(ROOT . '/index/index?flash=Gallery id is missing.&title=Can\'t delete gallery.');
        }
        $id = intval($this->request->params['passed']['id']);
        $gallery = (new Gallery())->readById($id);
        if (intval($gallery->getUser()->getId()) !== intval($this->request->session['user_id'])) {
            return $this->redirect(ROOT . '/index/index?flash=You are not allowed to delete this gallery&title=Missing permissions');
        }
        if ($gallery->delete()) {
            return $this->redirect(ROOT . '/index/index');
        } else {
            return $this->redirect(ROOT . '/index/index?flash=Can\'t delete gallery. Unkown problem&title=Fail while deleting gallery.');
        }
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