<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.05.2016
 * Time: 22:02
 */

namespace MKWeb\ImgDB\Controller;


use MKWeb\ImgDB\Model\Gallery;

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

        $gallery = (new Gallery())->readById($id);
        $dirName = sha1($gallery->getName() . $gallery->getId()) . '/';
        $galleryDir = FINAL_GALLERY_DIR . $dirName;
        $galleryThumbnailDir = THUMBNAIL_GALLERY_DIR . $dirName;

        if (!in_array($file['type'], $allowed_types)) return $this->redirect(ROOT . '/gallery/index?id=' . $id . '&title=Shit2');

        $newfilename = hash('sha256', $filename . time()) . '.' . end(explode('.', $file['name']));

        if (move_uploaded_file($file['tmp_name'], $galleryDir . $newfilename) === false) {
            return $this->redirect(ROOT . '/gallery/index?id=' . $id);
        }

        list($width, $height) = getimagesize($galleryDir . $newfilename);
        $newheight = THUMBNAIL_HEIGHT;
        $newwidth = $width / ($height / THUMBNAIL_HEIGHT);

        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($galleryDir . $newfilename);

        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        imagejpeg($thumb, $galleryThumbnailDir . $newfilename);

        return $this->redirect(ROOT . '/gallery/index?id=' . $id);
    }

}