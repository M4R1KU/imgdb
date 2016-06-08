<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.05.2016
 * Time: 14:22
 */

namespace MKWeb\ImgDB\Model;


class Image extends Model {


    private $id;
    private $title;
    private $description;
    /**
     * @var Gallery
     */
    private $gallery;
    private $file_path;

    /**
     * Image constructor.
     * @param $id
     * @param null $gallery
     * @param null $title
     * @param $description
     * @param null $file_path
     */
    public function __construct($id = null, $gallery = null, $title = null, $description = null, $file_path = null) {
        parent::__construct(__CLASS__);
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->gallery = $gallery;
        $this->file_path = $file_path;
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
            return new static($image['image_id'],(new Gallery)->readById($image['id_gallery']), $image['title'], $image['description'], $image['file_path']);
        }
        else return null;
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @return bool
     */
    public function create() {
        $query = $this->connection->prepare("INSERT INTO Image (id_gallery, title, description, file_path) VALUES (?, ?, ?, ?)");
        $query->bind_param('isss', $this->gallery->getId(), $this->title, $this->description, $this->file_path);
        if (!$query->execute()) return false;
        $this->id = $this->connection->insert_id;
        return true;
    }

    public function setGalleryById($gallery_id) {
        $this->gallery = (new User())->readById(intval($gallery_id));
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

    public function delete() {
        return $this->deleteById($this->id);
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

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param Gallery $gallery
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * @return null
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * @param null $file_path
     */
    public function setFilePath($file_path)
    {
        $this->file_path = $file_path;
    }

    function __toString()
    {
        return $this->id ."";
    }


}