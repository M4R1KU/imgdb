<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 21.05.2016
 * Time: 13:55
 */

namespace MKWeb\ImgDB\Controller;


use MKWeb\ImgDB\Model\Gallery;
use MKWeb\ImgDB\Model\Image;

class GalleryController extends Controller
{

    public function index() {
        if (!isset($this->request->params['passed']['id'])) {
            return $this->redirect(ROOT . '/Error/index?error=400&msg=Gallery id is missing.');
        }
        $id = intval($this->request->params['passed']['id']);
        $gallery = (new Gallery())->readById($id);
        if (!$gallery) return $this->redirect(ROOT . '/Error/index?error=404&msg=Can\'t find gallery.');

        $images = (new Image())->getImagesByGallery($gallery);
        $this->view->assign('images', $images);
        $this->view->assign('gallery', $gallery);

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
    
    public function edit() {
        if (!isset($this->request->params['passed']['id'])) {
            return $this->redirect(ROOT . '/index/index?flash=Gallery id is missing.&title=Can\'t edit gallery.');
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

        $dirName = sha1($gallery->getName() . $gallery->getId()) . '/';
        $galleryDir = ABS_FINAL_GALLERY_DIR . $dirName;
        $galleryThumbnailDir = ABS_THUMBNAIL_GALLERY_DIR . $dirName;
        if (!is_dir($galleryDir)) mkdir($galleryDir);
        if (!is_dir($galleryThumbnailDir)) mkdir($galleryThumbnailDir);
        
        $this->redirect(ROOT . '/index/index');
    }

}
