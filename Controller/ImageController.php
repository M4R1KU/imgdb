<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.05.2016
 * Time: 22:02
 */

namespace MKWeb\ImgDB\Controller;


use MKWeb\ImgDB\Model\Entity\Image;
use MKWeb\ImgDB\Model\Entity\ImageTag;
use MKWeb\ImgDB\Model\Entity\Tag;
use MKWeb\ImgDB\Model\GalleryTable;
use MKWeb\ImgDB\Model\ImageTable;
use MKWeb\ImgDB\Model\ImageTagTable;
use MKWeb\ImgDB\Model\TagTable;

class ImageController extends Controller {
    
    public function show() {
        if (!isset($this->request->params['passed']['id'])) {
            return $this->redirect('/Error/index?error=400');
        }
        $imageTable = new ImageTable();
        $imageTagTable = new ImageTagTable();
        
        $id = $this->request->params['passed']['id'];
        $image = $imageTable->readById($id);
        $gallery = $image->getGallery();
        if ($gallery->getUser()->getId() != $this->request->session['user_id']) {
            if ($gallery->isPrivate()) {
                return $this->redirect('/Error/index?error=403&msg=You are not allowed to see this picture.');
            }
        }
        $currentImage = $prevImage = $nextImage = null;
        $images = $imageTable->getImagesByGallery($gallery);
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
        
        $imgTags = $imageTagTable->readByImage($image);
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
        $galleryTable = new GalleryTable();
        $imageTable = new ImageTable();
        $tagTable = new TagTable();
        $imageTagTable = new ImageTagTable();
        $allowed_types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

        $id = intval($this->request->params['passed']['image_add_gallery_id']);
        $file = $this->request->params['passed']['image_add_file'];
        $filename = $this->request->params['passed']['image_add_filename'];
        $tagsRequest = explode(',', $this->request->params['passed']['image_add_tags']);

        if (!in_array($file['type'], $allowed_types)) return $this->redirect('/gallery/index' .generateFlash('File-type not allowed', 'warning') . '&id=' . $id);

        $gallery = $galleryTable->readById($id);

        if ($this->request->session['user_id'] != $gallery->getUser()->getId()) {
            return $this->redirect('/index/index'. generateFlash('You are not allowed to add images in this gallery.', 'warning'));
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
        
        $image = $imageTable->create(new Image(null, null, null, $gallery, $newFilename));

        if (count($tagsRequest) > 0) {
            foreach ($tagsRequest as $tag) {
                if ($tag != '') {
                    if (!$newTag = $tagTable->exists($tag)) {
                        $newTag = $tagTable->create(new Tag(null, $tag));
                    }
                    $imageTagTable->create(new ImageTag(null, $image, $newTag));
                }
            }
        }
        return $this->redirect('/gallery/index?id=' . $id);
    }

    public function edit() {
        if (!isset($this->request->params['passed']['image_edit_title']) || (!isset($this->request->params['passed']['image_edit_description']))) return $this->redirect('/Error/index?id=400');
        $imageTable = new ImageTable();


        $title = $this->request->params['passed']['image_edit_title'];
        $description = $this->request->params['passed']['image_edit_description'];
        $id = $this->request->params['passed']['image_edit_id'];

        $image = $imageTable->readById($id);

        if ($image->getGallery()->getUser()->getId() != $this->request->session['user_id']) return $this->redirect('/Error/index?error=403');

        $image->setTitle($title);
        $image->setDescription($description);
        if ($imageTable->update($image)) {
            return $this->redirect('/image/show' . generateFlash('Image attributes updated.', 'success') . '&id=' . $id);
        }
        return $this->redirect('/image/show' . generateFlash('Error while updating image attributes.', 'error') . '&id=' . $id);
    }


    public function delete() {
        if (empty($this->request->params['passed']['id'])) return $this->redirect('/Error/index?error=400');
        $imageTable = new ImageTable();

        $id = $this->request->params['passed']['id'];
        $image = $imageTable->readById($id);

        if ($image->getGallery()->getUser()->getId() != $this->request->session['user_id']) return $this->redirect('/Error/index?error=403');

        if ($imageTable->delete($image)) {
            return $this->redirect('/gallery/index?id=' . $image->getGallery()->getId());
        }
        return $this->redirect('/gallery/index' . generateFlash('Couldn\'t delete image.', 'error') . '&id=' . $image->getGallery()->getId());
    }


    // TODO
    public function index() {
        if (empty($this->request->params['passed']['name']) || empty($this->request->params['passed']['gid'])) return $this->redirect('/Error/index?error=400');
        $galleryTable = new GalleryTable();
        $imageTable = new ImageTable();

        $name = $this->request->params['passed']['name'];
        $gallery = $galleryTable->readById($this->request->params['passed']['gid']);
        $filename = ABS_FINAL_GALLERY_DIR . getGalleryHash($gallery) . '/' . $name;
        if (file_exists($filename)) {
            if ($imageTable->userCanSeePicture($name, $this->request->session['user_id'])) {
                $this->response->header('Content-Type', mime_content_type($filename));
                $this->response->header('Content-Length', filesize($filename));
                return $this->response->body(file_get_contents($filename));
            }
            else {
                return $this->redirect('/Error/index?error=403&msg=You are not allowed to see this image');
            }

        }
        return $this->redirect('/Error/index?error=404&The requested image was not found on the server');
    }

}