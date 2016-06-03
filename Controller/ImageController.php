<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.05.2016
 * Time: 22:02
 */

namespace MKWeb\ImgDB\Controller;


use MKWeb\ImgDB\Model\Gallery;
use MKWeb\ImgDB\Model\Image;
use MKWeb\ImgDB\Model\ImageTag;
use MKWeb\ImgDB\Model\Tag;

class ImageController extends Controller {
    
    public function index() {
        
    }
    
    public function add() {
        if (!isset($this->request->params['passed']['image_add_file'])) {
            return $this->redirect(ROOT . isset($this->request->params['passed']['image_add_gallery_id']) ? '/gallery/index?id=' . $this->request->params['passed']['image_add_gallery_id'] . '&title=Shit1' : '/index/index' . '&title=Shit1');
        }
        $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];

        $id = intval($this->request->params['passed']['image_add_gallery_id']);
        $file = $this->request->params['passed']['image_add_file'];
        $filename = $this->request->params['passed']['image_add_filename'];
        $tagsRequest = explode(',', $this->request->params['passed']['image_add_tags']);

        $gallery = (new Gallery())->readById($id);
        $dirName = sha1($gallery->getName() . $gallery->getId()) . '/';
        $galleryDir = ABS_FINAL_GALLERY_DIR . $dirName;
        $galleryThumbnailDir = ABS_THUMBNAIL_GALLERY_DIR . $dirName;

        if (!in_array($file['type'], $allowed_types)) return $this->redirect(ROOT . '/gallery/index?id=' . $id . '&title=Shit2');

        $newFilename = hash('sha256', $filename . time()) . '.' . end(explode('.', $file['name']));

        $file_path = $galleryDir . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $file_path) === false) {
            return $this->redirect(ROOT . '/gallery/index?id=' . $id);
        }

        resizeAndMoveImage($galleryDir, $galleryThumbnailDir, $newFilename);

        $image = new Image(null, $gallery, null, null, $newFilename);
        $image->create();

        if (count($tagsRequest) > 0) {
            foreach ($tagsRequest as $tag) {
                $t = new Tag();
                if (!$t->exists($tag)) {
                    $t->create();
                }
                (new ImageTag(null, $image, $t))->create();
            }
        }
        return $this->redirect(ROOT . '/gallery/index?id=' . $id);
    }

}