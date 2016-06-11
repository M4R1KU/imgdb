<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 01.06.2016
 * Time: 20:15
 */

namespace MKWeb\ImgDB\Model;

use MKWeb\ImgDB\Model\Entity\Image;
use MKWeb\ImgDB\Model\Entity\ImageTag;
use MKWeb\ImgDB\Model\Entity\Tag;


class ImageTagTable extends Model implements Table {
    /**
     * ImageTagTable constructor.
     */
    public function __construct() {
        parent::__construct(ImageTag::class);
    }


    /**
     * if $tag is already instance of ImageTag it will return $imageTag
     * if it is an array it will create a new ImageTag object
     * @param $imageTag
     * @return Tag|static
     */
    public static function constructImageTag($imageTag) {
        if ($imageTag instanceof ImageTag) {
            return $imageTag;
        }
        else if (is_array($imageTag)) {
            return new ImageTag($imageTag['image_tag_id'], (new ImageTable)->readById($imageTag['id_image']), (new TagTable)->readById($imageTag['id_tag']));
        }
        else return null;
    }

    /**
     * inserts a new row into the table with the instancevariables
     * and sets the id for the current object
     *
     * @param ImageTag $imageTag
     * @return bool|ImageTag
     */
    public function create($imageTag) {
        $query = $this->connection->prepare("INSERT INTO image_tag (id_image, id_tag) VALUES (?, ?)");
        $query->bind_param('ii',$imageTag->getImage()->getId(), $imageTag->getTag()->getId());
        if (!$query->execute()) return false;
        $imageTag->setId($this->connection->insert_id);
        return $imageTag;
    }

    public function deleteById($id) {
        $query = $this->connection->prepare("DELETE FROM image_tag WHERE image_id_id = ?");
        $query->bind_param('i', intval($id));
        return $this->exec($query);
    }

    /**
     * @param ImageTag $imageTag
     * @return bool
     */
    public function delete($imageTag) {
        return $this->deleteById($imageTag->getId());
    }
    
    public function readByImage(Image $img) {
        $query = $this->connection->prepare("SELECT * FROM image_tag WHERE id_image = ?");
        $query->bind_param('i', intval($img->getId()));
        $res = $this->readAllArray($query);
        $out = [];
        foreach ($res as $imageTag) {
            $out[] = $this->constructImageTag($imageTag);
        }
        return $out;
    }
    
    public function readByTag(Tag $tag) {
        $query = $this->connection->prepare("SELECT * FROM image_tag WHERE id_tag = ?");
        $query->bind_param('i', intval($tag->getId()));
        $res = $this->readAllOrSingle($query);
        $out = [];
        foreach ($res as $imageTag) {
            $out[] = $this->constructImageTag($imageTag);
        }
        return $out;
    }

    /**
     * return an array with every ImageTag in it which are available in the database
     *
     * @return array
     */
    public function readAll() {
        $res = parent::readAll();
        $out = [];
        foreach ($res as $imageTag) {
            $out[] = $this->constructImageTag($imageTag);
        }
        return $out;

    }


    /**
     * returns the Tag with the given id
     *
     * @param $id
     * @return Tag
     */
    public function readById($id)
    {
        return $this->constructImageTag(parent::readById($id));
    }   

}