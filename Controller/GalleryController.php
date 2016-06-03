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
            return $this->redirect('/Error/index?error=400&msg=Gallery id is missing.');
        }
        $id = intval($this->request->params['passed']['id']);
        $gallery = (new Gallery())->readById($id);
        if (!$gallery) return $this->redirect('/Error/index?error=404&msg=Can\'t find gallery.');

        $images = (new Image())->getImagesByGallery($gallery);
        $this->view->assign('images', $images);
        $this->view->assign('gallery', $gallery);

    }

    public function delete() {
        if (!isset($this->request->params['passed']['id'])){
            return $this->redirect('/index/index' . generateFlash('Gallery id is missing. Can\'t delete gallery.', 'error'));
        }
        $id = intval($this->request->params['passed']['id']);
        $gallery = (new Gallery())->readById($id);
        if (intval($gallery->getUser()->getId()) !== intval($this->request->session['user_id'])) {
            return $this->redirect('/index/index'. generateFlash('You are not allowed to delete this gallery', 'warning'));
        }
        if ($gallery->delete()) {
            return $this->redirect('/index/index');
        } else {
            return $this->redirect('/index/index' .generateFlash('Can\'t delete gallery. Unknown problem while deleting gallery', 'error'));
        }
    }
    
    public function edit() {
        if (!isset($this->request->params['passed']['id'])) {
            return $this->redirect('/index/index' . generateFlash('Gallery id is missing. Can\'t edit gallery.', 'error'));
        }
    }
    
    public function add() {
        if (!isset($this->request->params['passed']['gallery_add_name']) &&
            !isset($this->request->params['passed']['gallery_add_description'])) {
            return $this->redirect('/index/index' . generateFlash('Some essential information is missing. Could not create a new gallery.', 'error'));
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

        $dirName = getGalleryHash($gallery) . '/';
        $galleryDir = ABS_FINAL_GALLERY_DIR . $dirName;
        $galleryThumbnailDir = ABS_THUMBNAIL_GALLERY_DIR . $dirName;
        if (!is_dir($galleryDir)) mkdir($galleryDir);
        if (!is_dir($galleryThumbnailDir)) mkdir($galleryThumbnailDir);
        
        $this->redirect('/index/index');
    }

}
