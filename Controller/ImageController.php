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
    
    public function show() {
        if (!isset($this->request->params['passed']['id'])) {
            return $this->redirect('/Error/index?error=400');
        }
        $id = $this->request->params['passed']['id'];
        $image = (new Image())->readById($id);
        $gallery = $image->getGallery();
        if ($gallery->getUser()->getId() != $this->request->session['user_id']) {
            if ($gallery->isPrivate() === true) {
                return $this->redirect('/Error/index?error=403&msg=You are not allowed to see this picture.');
            }
        }
        $currentImage = $prevImage = $nextImage = null;
        $images = (new Image())->getImagesByGallery($gallery);
        for ($i = 0; $i < count($images); $i++) {
            if ($images[$i] instanceof Image && $images[$i]->getId() == $id) {
                $currentImage = $images[$i];
                $nextImage = isset($images[$i+1]) ? $images[$i+1] : null;
                $prevImage = isset($images[$i-1]) ? $images[$i-1] : null;
                break;
            }
        }
        if ($currentImage === null) {
            return $this->redirect('/Error/index?error=404&msg=Image not found :/');
        }
        
        $imgTags = (new ImageTag())->readByImage($image);
        $tags = [];
        if (count($imgTags) > 0) {
            /** @var ImageTag $imgTag */
            foreach ($imgTags as $imgTag) {
                $tags[] = $imgTag->getTag();
            }
        }
        $this->view->assign('tags', $tags);
        $this->view->assign('gallery', $gallery);
        $this->view->assign('currentImage', $currentImage);
        $this->view->assign('nextImage', $nextImage);
        $this->view->assign('prevImage', $prevImage);
    }
    
    public function add() {
        if (empty($this->request->params['passed']['image_add_file']) || empty($this->request->params['passed']['image_add_filename'])) {
            $flash = generateFlash('File to upload is missing', 'error');
            return $this->redirect(isset($this->request->params['passed']['image_add_gallery_id']) ? '/gallery/index' . $flash . '&id=' . $this->request->params['passed']['image_add_gallery_id'] : '/index/index' . $flash);
        }
        $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];

        $id = intval($this->request->params['passed']['image_add_gallery_id']);
        $file = $this->request->params['passed']['image_add_file'];
        $filename = $this->request->params['passed']['image_add_filename'];
        $tagsRequest = explode(',', $this->request->params['passed']['image_add_tags']);

        if (!in_array($file['type'], $allowed_types)) return $this->redirect('/gallery/index' .generateFlash('File-type not allowed', 'warning') . '&id=' . $id);

        $gallery = (new Gallery())->readById($id);

        if ($this->request->session['user_id'] != $gallery->getUser()->getId()) {
            return $this->redirect('/gallery/index'. generateFlash('You are not allowed to add images in this gallery.', 'warning') . '&id=' . $id);
        }

        $dirName = getGalleryHash($gallery) . '/';
        $galleryDir = ABS_FINAL_GALLERY_DIR . $dirName;
        $galleryThumbnailDir = ABS_THUMBNAIL_GALLERY_DIR . $dirName;

        $newFilename = getImageHash($filename);
        $file_path = $galleryDir . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $file_path) === false) {
            return $this->redirect('/gallery/index?id=' . $id);
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
        return $this->redirect('/gallery/index?id=' . $id);
    }

    // TODO
    public function index() {
        if (empty($this->request->params['passed']['name']) || empty($this->request->params['passed']['gid'])) return $this->redirect('/error/index?error=400');

        $name = $this->request->params['passed']['name'];
        $gallery = (new Gallery())->readById($this->request->params['passed']['gid']);
        $filename = ABS_FINAL_GALLERY_DIR . getGalleryHash($gallery) . '/' . $name;
        if (file_exists($filename)) {
            if ((new Image())->userCanSeePicture($name, $this->request->session['user_id'])) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $this->response->header('Content-Type', finfo_file($finfo, $filename));
                $this->response->header('Content-Length', filesize($filename));
                finfo_close($finfo);
                return $this->response->body(file_get_contents($filename));
            }
            else {
                return $this->redirect('/error/index?error=403&msg=You are not allowed to see this image');
            }

        }
        return $this->redirect('/error/index?error=404&The requested image was not found on the server');
    }

}