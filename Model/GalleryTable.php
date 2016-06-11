<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.05.2016
 * Time: 13:44
 */

namespace MKWeb\ImgDB\Model;


use MKWeb\ImgDB\Model\Entity\Gallery;
use MKWeb\ImgDB\Model\Entity\User;

class GalleryTable extends Model
{
    /**
     * Gallery constructor.
     */
    public function __construct() {
        parent::__construct(Gallery::class);
    }


    /**
     * if $gallery is already instance of Gallery it will return $com
     * if it is an array it will create a new Gallery objcet
     *
     * @param $gallery
     * @return Gallery object
     */
    public static function constructGallery($gallery) {
        if ($gallery instanceof Gallery) {
            return $gallery;
        }
        else if (is_array($gallery)) {
            return new Gallery($gallery['gallery_id'], $gallery['name'], $gallery['description'], (new UserTable)->readById($gallery['id_user']), $gallery['private']);
        }
        else return null;
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @param Gallery $gallery
     * @return bool|Gallery
     */
    public function create($gallery) {
        $query = $this->connection->prepare("INSERT INTO gallery (id_user, name, description, private) VALUES (?, ?, ?, ?)");
        $query->bind_param('issi', $gallery->getUser()->getId(), $gallery->getName(), $gallery->getDescription(), $gallery->isPrivate());
        if (!$query->execute()) return false;
        $gallery->setId($this->connection->insert_id);
        return $gallery;
    }

    /**
     * @param Gallery $gallery
     * @param $user_id
     * @return Gallery
     */
    public function setUserById($gallery, $user_id) {
        $gallery->setUser((new UserTable())->readById(intval($user_id)));
        return $gallery;
    }
    
    public function getGalleriesByUser(User $user) {
        $uid = $user->getId();
        $query = $this->connection->prepare("SELECT * FROM gallery WHERE id_user = ?");
        $query->bind_param('i', intval($uid));
        $res = $this->readAllOrSingle($query);
        if (!$res) return $res;
        if (!isset($res[0])) return [$this->constructGallery($res)];
        $arr = [];
        foreach ($res as $u) {
            $arr[] = $this->constructGallery($u);
        }
        return $arr;
    }
    
    public function getPublicGalleries(){
        $query = $this->connection->prepare("SELECT * FROM gallery WHERE private = 0");
        $res = $this->readAllOrSingle($query);
        if (!$res) return $res;
        if (!isset($res[0])) return [$this->constructGallery($res)];
        $arr = [];
        foreach ($res as $u) {
            $arr[] = $this->constructGallery($u);
        }
        return $arr;
    }
    
    public function deleteById($id) {
        $query = $this->connection->prepare("DELETE FROM gallery WHERE gallery_id = ?");
        $query->bind_param('i', intval($id));
        return $this->exec($query);
    }

    /**
     * @param Gallery $gallery
     * @return bool
     */
    public function delete($gallery) {
        return $this->deleteById($gallery->getId());
    }

    /**
     * @param Gallery $gallery
     * @return bool
     */
    public function update($gallery) {
        $query = $this->connection->prepare("UPDATE gallery SET name = ?, description = ?, private = ? WHERE gallery_id = ?");
        $query->bind_param('ssii', $gallery->getName(), $gallery->getDescription(), $gallery->isPrivate(), $gallery->getId());
        return $this->exec($query);
    }

    /**
     * return an array with every gallery in it which are available in the database
     *
     * @return array
     */
    public function readAll() {
        $res = parent::readAll();
        $out = [];
        foreach ($res as $user) {
            $out[] = $this->constructGallery($user);
        }
        return $out;

    }


    /**
     * returns the gallery id with the given id
     *
     * @param $id
     * @return Gallery
     */
    public function readById($id)
    {
        return $this->constructGallery(parent::readById($id));
    }
    
}