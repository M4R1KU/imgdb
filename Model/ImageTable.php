<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.05.2016
 * Time: 14:22
 */

namespace MKWeb\ImgDB\Model;


use MKWeb\ImgDB\Model\Entity\Gallery;
use MKWeb\ImgDB\Model\Entity\Image;

class ImageTable extends Model {
    /**
     * ImageTable constructor.
     */
    public function __construct() {
        parent::__construct(Image::class);
    }


    /**
     * if $image is already instance of Image it will return $com
     * if it is an array it will create a new Image objcet
     *
     * @param $image
     * @return Image object
     */
    public static function constructImage($image) {
        if ($image instanceof Image) {
            return $image;
        }
        else if (is_array($image)) {
            return new Image($image['image_id'], $image['title'], $image['description'], (new GalleryTable)->readById($image['id_gallery']), $image['file_path']);
        }
        else return null;
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @param Image $image
     * @return bool|Image
     */
    public function create($image) {
        $query = $this->connection->prepare("INSERT INTO Image (id_gallery, title, description, file_path) VALUES (?, ?, ?, ?)");
        $query->bind_param('isss', $image->getGallery()->getId(), $image->getTitle(), $image->getDescription(), $image->getFilePath());
        if (!$query->execute()) return false;
        $image->setId($this->connection->insert_id);
        return $image;
    }

    /**
     * @param Image $image
     * @param $gallery_id
     * @return mixed
     */
    public function setGalleryById($image, $gallery_id) {
        $image->setGallery((new GalleryTable())->readById(intval($gallery_id)));
        return $image;
    }

    /**
     * @param Gallery $gallery
     * @return array Image
     */
    public function getImagesByGallery(Gallery $gallery) {
        $gid = $gallery->getId();
        $query = $this->connection->prepare("SELECT * FROM Image WHERE id_gallery = ?");
        $query->bind_param('i', intval($gid));
        $res = $this->readAllOrSingle($query);
        if (!$res) return $res;
        if (!isset($res[0])) return [$this->constructImage($res)];
        $arr = [];
        foreach ($res as $u) {
            $arr[] = $this->constructImage($u);
        }
        return $arr;
    }

    public function deleteById($id) {
        $query = $this->connection->prepare("DELETE FROM Image WHERE image_id = ?");
        $query->bind_param('i', intval($id));
        return $this->exec($query);
    }

    /**
     * @param Image $image
     * @return bool
     */
    public function delete($image) {
        return $this->deleteById($image->getId());
    }

    /**
     * return an array with every gallery in it which are available in the database
     *
     * @return array
     */
    public function readAll() {
        $res = parent::readAll();
        $out = [];
        foreach ($res as $image) {
            $out[] = $this->constructImage($image);
        }
        return $out;

    }

    /**
     * 
     * TODO
     * @param $name
     * @param $user_id
     * @return bool
     */
    public function userCanSeePicture($name, $user_id) {
        $query = $this->connection->prepare("SELECT * FROM Image AS i JOIN Gallery AS g ON i.id_gallery = g.gallery_id JOIN User AS u ON g.id_user = u.user_id WHERE g.private = 0 OR i.file_path = ? AND u.user_id = ?");
        $query->bind_param('si', $name, intval($user_id));
        $res = $this->readAllArray($query);
        if ($res) return true;
        else return false;
    }


    /**
     * returns the Image with the given id
     *
     * @param $id
     * @return Image
     */
    public function readById($id)
    {
        return $this->constructImage(parent::readById($id));
    }
}