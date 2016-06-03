<?php
/**
 * Created by PhpStorm.
 * User: M4R1KU
 * Date: 01.06.2016
 * Time: 20:15
 */

namespace MKWeb\ImgDB\Model;


class ImageTag extends Model {

    private $id;
    /**
     * @var Image
     */
    private $image;
    /**
     * @var Tag
     */
    private $tag;

    /**
     * ImageTag constructor.
     * @param null $id
     * @param null $image
     * @param null $tag
     */
    public function __construct($id = null, $image = null, $tag = null)
    {
        parent::__construct(__CLASS__);
        $this->id = $id;
        $this->image = $image;
        $this->tag = $tag;
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
            return new static($imageTag['image_tag_id'], (new Image)->readById($imageTag['id_image']), (new Tag)->readById($imageTag['id_tag']));
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
        $query = $this->connection->prepare("INSERT INTO Image_Tag (id_image, id_tag) VALUES (?, ?)");
        $query->bind_param('ii',$this->image->getId(), $this->tag->getId());
        if (!$query->execute()) return false;
        $this->id = $this->connection->insert_id;
        return true;
    }

    public function deleteById($id) {
        $query = $this->connection->prepare("DELETE FROM Image_Tag WHERE image_id_id = ?");
        $query->bind_param('i', intval($id));
        return $this->exec($query);
    }

    public function delete() {
        return $this->deleteById($this->id);
    }
    
    public function readByImage(Image $img) {
        $query = $this->connection->prepare("SELECT * FROM Image_Tag WHERE id_image = ?");
        $query->bind_param('i', intval($img->getId()));
        $res = $this->readAllOrSingle($query);
        $out = [];
        foreach ($res as $imageTag) {
            $out[] = $this->constructImageTag($imageTag);
        }
        return $out;
    }
    
    public function readByTag(Tag $tag) {
        $query = $this->connection->prepare("SELECT * FROM Image_Tag WHERE id_tag = ?");
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
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param Tag $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
    
    

}